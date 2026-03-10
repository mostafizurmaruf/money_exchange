<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\User;
use DB;

class SiteController extends Controller
{
    public function dashboard(){
        return view('dashboard');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect(route('login'));
    }

    public function users(){
        $data = User::where('id','!=',1)->paginate(20);
        return view("user",compact("data"));
    }

    public function userDelete(Request $request){
        User::whereId($request->id)->delete();
        return redirect()->back();
    }

    public function service(){
        $data = DB::table('gateways')->orderBy('id','DESC')->paginate(20);
        return view("service",compact('data'));
    }

    public function serviceDelete(Request $request){
        DB::table('gateways')->whereId($request->id)->delete();
        return redirect()->back();
    }

    public function add_service(){
        return view("add_service");
    }

    public function add_service_submit(Request $request){

        $request->validate([
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);


        // Store image
        if ($request->hasFile('thumbnail')) {
            $destinationPath = public_path('thumbnails');
            $file = $request->file('thumbnail');
            $fileName = $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
        }else{
            $fileName = null;
        }

        // Save to database
        DB::table('gateways')->insert([
            "name" => $request->name,
            "currency" => $request->currency,
            "reserve" => $request->reserve,
            "min_amount" => $request->min_amount,
            "max_amount" => $request->max_amount,
            "external_icon" => $fileName,
            "fee" => $request->fee
        ]);

        return redirect()->back()->withSuccess("Exchange uploaded successfully!");

    }

    public function edit_service(Request $request){
        $data = DB::table('gateways')->whereId($request->id)->first();
        return view("edit_service",compact('data'));
    }

    public function edit_service_submit(Request $request){
        // Store image
        if ($request->hasFile('thumbnail')) {
            $destinationPath = public_path('thumbnails');
            $file = $request->file('thumbnail');
            $fileName = $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
        }else{
            $image = DB::table('gateways')->whereId($request->id)->value("external_icon");
            $fileName = $image;
        }

        // Save to database
        DB::table('gateways')->whereId($request->id)->update([
            "name" => $request->name,
            "currency" => $request->currency,
            "reserve" => $request->reserve,
            "min_amount" => $request->min_amount,
            "max_amount" => $request->max_amount,
            "external_icon" => $fileName,
            "fee" => $request->fee
        ]);

        return redirect()->back()->withSuccess("Service edited successfully!");
    }


    public function transection(){
        $data = DB::table('exchanges')
            ->join('users', 'exchanges.uid', '=', 'users.id')
            ->join('gateways as send_gateway', 'exchanges.gateway_send', '=', 'send_gateway.id')
            ->join('gateways as receive_gateway', 'exchanges.gateway_receive', '=', 'receive_gateway.id')
            ->select(
                'exchanges.*',
                'send_gateway.name as send_gateway_name',
                'receive_gateway.name as receive_gateway_name',
                'users.email as user_email'
            )
            ->orderBy('id','DESC')
            ->paginate(20);
        return view("transection",compact('data'));
    }

    public function transectionDelete(Request $request){
        DB::table('exchanges')->whereId($request->id)->delete();
        return redirect()->back();
    }


    public function search(Request $request){
        // Validate input
        $request->validate([
            'page_name' => 'required|string',
            'db' => 'required|string',
            'cl' => 'required|string',
            'search' => 'required|string',
        ]);

        // Query builder instance
        $query = DB::table($request->db);

        if ($request->cl == "uid") {
            // Find user ID by email in `users` table
            $user = DB::table('users')->where('email', $request->search)->first();
            if (!$user) {
                abort(403, "Invalid user ID.");
            }
            $query->where('uid', $user->id);
        }else if ($request->cl == "transaction_id") {
            $query
                ->where('transaction_id',$request->search)
                ->join('users', 'exchanges.uid', '=', 'users.id')
                ->join('gateways as send_gateway', 'exchanges.gateway_send', '=', 'send_gateway.id')
                ->join('gateways as receive_gateway', 'exchanges.gateway_receive', '=', 'receive_gateway.id')
                ->select(
                    'exchanges.*',
                    'send_gateway.name as send_gateway_name',
                    'receive_gateway.name as receive_gateway_name',
                    'users.email as user_email'
                )
                ->paginate(20);
        }else {
            // Perform a LIKE search
            $query->where($request->cl, 'like', "%{$request->search}%");
        }

        // Paginate results
        $data = $query->paginate(20);

        return view($request->page_name,compact('data'));
    }


    public function transactionStatus(Request $request){
        DB::table('exchanges')->whereId($request->id)->update([
            "status" => $request->status,
        ]);

        $transactionData = DB::table('exchanges')->whereId($request->id)->first();

        $send = DB::table('gateways')->whereId($transactionData->gateway_send)->value('reserve');
        DB::table('gateways')->whereId($transactionData->gateway_send)->update([
            "reserve" => $send + $transactionData->amount_send
        ]);

        $received = DB::table('gateways')->whereId($transactionData->gateway_receive)->value('reserve');
        DB::table('gateways')->whereId($transactionData->gateway_receive)->update([
            "reserve" => $received - $transactionData->amount_receive
        ]);

        return response()->json(['success' => true, 'message' => "Status Changed"]);
    }


    public function transactionDetails(Request $request){
        $request->validate(['id' => 'required|integer']);

        $transaction = DB::table('exchanges')->where('id', $request->id)->first();

        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaction not found']);
        }

        return response()->json([
            'success' => true,
            'transaction' => $transaction
        ]);
    }

    public function rates(){
        $data = DB::table('rates')
        ->join('gateways as send_gateway', 'rates.gateway_from', '=', 'send_gateway.id')
        ->join('gateways as receive_gateway', 'rates.gateway_to', '=', 'receive_gateway.id')
        ->select(
            'rates.*',
            'send_gateway.name as send_gateway_name',
            'receive_gateway.name as receive_gateway_name',
            'send_gateway.currency as send_gateway_currency',
            'receive_gateway.currency as receive_gateway_currency'
        )
        ->orderBy('id','DESC')
        ->paginate(20);
        return view('rates',compact('data'));
    }

    public function ratesDelete(Request $request){
        DB::table('rates')->whereId($request->id)->delete();
        return redirect()->back();
    }

    public function add_rates(){
        return view('add_rates');
    }

    public function add_rates_submit(Request $request){
        DB::table('rates')->insert([
            "gateway_from" => $request->gateway_from,
            "gateway_to" => $request->gateway_to,
            "rate_from" => $request->rate_from,
            "rate_to" => $request->rate_to,
        ]);

        return redirect()->back()->withSuccess("Service edited successfully!");
    }

    public function edit_rates(Request $request){
        $data = DB::table('rates')->whereId($request->id)->first();
        return view('edit_rates',compact('data'));
    }

    public function edit_rates_submit(Request $request){
        DB::table('rates')->whereId($request->id)->update([
            "gateway_from" => $request->gateway_from,
            "gateway_to" => $request->gateway_to,
            "rate_from" => $request->rate_from,
            "rate_to" => $request->rate_to,
        ]);

        return redirect()->back()->withSuccess("Rates edited successfully!");
    }

    public function settings(){
        return view('settings');
    }

    public function settingsSubmit(Request $request){
        if(isset($request->password)){
            DB::table('users')->whereId(1)->update([
                "password" => Hash::make($request->password),
            ]);
            return redirect()->back()->withSuccess("Settings edited successfully!");
        }

        if ($request->hasFile('logo')) {
            $destinationPath = public_path('assets/img');
            $file = $request->file('logo');
            $fileName = $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
        }else{
            $image = DB::table('settings')->value("logo");
            $fileName = $image;
        }

        if ($request->hasFile('favicon')) {
            $destinationPath = public_path('assets/img');
            $file = $request->file('favicon');
            $fileName1 = $file->getClientOriginalName();
            $file->move($destinationPath, $fileName1);
        }else{
            $image1 = DB::table('settings')->value("favicon");
            $fileName1 = $image1;
        }

        DB::table('settings')->update([
            "withdraw_info" => $request->withdraw_info,
            "exchangerate_api" => $request->exchange_api,
            "notice" => $request->notice,
            "logo" => $fileName,
            "favicon" => $fileName1,
        ]);
        return redirect()->back()->withSuccess("Settings edited successfully!");
    }


}



