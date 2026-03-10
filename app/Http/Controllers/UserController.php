<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
	public function dashboard(){
		return view('user.dashboard');
	}

	public function logout(){
        Session::flush();
        Auth::logout();
        return Redirect(route('user.index'));
    }

    public function exchange(Request $request){
		$gateway_send = $request->gateway_sn;
		$gateway_receive = $request->gateway_rc;
		$gateway_sendname = DB::table('gateways')->whereId($gateway_send)->value('name');
		$gateway_receivename = DB::table('gateways')->whereId($gateway_receive)->value('name');
		$currency_from = DB::table('gateways')->whereId($gateway_send)->value('currency');
		$currency_to = DB::table('gateways')->whereId($gateway_receive)->value('currency');
		$fee = DB::table('gateways')->whereId($gateway_receive)->value('fee');

		$data = DB::table('rates')->where('gateway_from',$gateway_send)->where('gateway_to',$gateway_receive)->count();

		if($data > 0){
			$row = DB::table('rates')->where('gateway_from',$gateway_send)->where('gateway_to',$gateway_receive)->first();
			$rate_from = $row->rate_from;
			$rate_to = $row->rate_to;
			}else{
				if($currency_from == $currency_to) { 
					$fee = str_ireplace("-","",$fee);
					$calculate1 = (1 * $fee) / 100;
					$calculate2 = 1 - $calculate1;
					$rate_from = 1;
					$rate_to = $calculate2;
					$fees = '-'.$calculate1;
				}else{
					$fees = 0;
					$rate_from = 1;
					$calculate = $this->currencyConvertor($rate_from,$currency_from,$currency_to);
					$calculate1 = ($calculate * $fee) / 100;
					$calculate2 = $calculate - $calculate1;
					if($calculate2 < 1) { 
						$calculate = $this->currencyConvertor($rate_from,$currency_to,$currency_from);
						$calculate1 = ($calculate * $fee) / 100;
						$calculate2 = $calculate - $calculate1;
						$rate_from = number_format($calculate2, 2, '.', '');
						$rate_to = 1;
					} else {
						$rate_to = number_format($calculate2, 2, '.', '');
					}
				}
			}

			$json['status'] = 'success';
			$json['rate_from'] = $rate_from; 
			$json['rate_to'] = $rate_to;
			$json['currency_form'] = $currency_from;
			$json['fees'] = $fees;
			$json['currency_to'] = $currency_to;

			return response()->json($json);
	}


	public function currencyConvertor($rate_from, $currency_from, $currency_to)
	{
	    $apiKey = DB::table('settings')->value('exchangerate_api'); // Replace with your API key
	    $rate_from = floatval($rate_from); // Convert to number

	    $url = "https://v6.exchangerate-api.com/v6/{$apiKey}/pair/{$currency_from}/{$currency_to}/{$rate_from}";

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_URL, $url);
	    $response = curl_exec($ch);
	    curl_close($ch);

	    $data = json_decode($response, true);

	    if ($data && isset($data['conversion_result'])) {
	        return number_format(floatval($data['conversion_result']), 2, '.', '');
	    } else {
	        return "Conversion Error!";
	    }
	}


	public function exchangeImage(Request $request){
		$json = DB::table('gateways')->whereId($request->id)->first();
		return response()->json($json);
	}


	public function profile(){
		return view('user.profile');
	}

	public function profileSubmit(Request $request){
		$id = Auth::user()->id;

		if ($request->has('password')) {
			DB::table('users')->whereId($id)->update([
				"name" => $request->name,
				"phone" => $request->phone,
				"password" => Hash::make($request->password)
			]);
		}else{
			DB::table('users')->whereId($id)->update([
				"name" => $request->name,
				"phone" => $request->phone
			]);
		}
		
		return redirect()->back()->with('success',"Update Successfully");
	}

	public function transection(){
		return view('user.transection');
	}

	public function exchangeSubmit(Request $request){
		$bit_amount_send = $request->bit_amount_send;
		$bit_amount_receive = $request->bit_amount_receive;
		$bit_rate_from = $request->bit_rate_from;
		$bit_rate_to = $request->bit_rate_to;
		$bit_gateway_send = $request->bit_gateway_send;
		$bit_gateway_receive = $request->bit_gateway_receive;
		$fees_txt = $request->fees_txt;

		// Fetch gateway data
		$bit_gateway_send_data = DB::table('gateways')->where('id', $bit_gateway_send)->first();
		$bit_gateway_receive_data = DB::table('gateways')->where('id', $bit_gateway_receive)->first();

		if (!$bit_gateway_send_data || !$bit_gateway_receive_data) {
		    return response()->json(['success' => false, 'message' => "Invalid gateway selected."]);
		}

		// Validate minimum and maximum amount for send gateway
		if ($bit_amount_send < $bit_gateway_send_data->min_amount) {
		    return response()->json(['success' => false, 'message' => "Minimum send amount is " . $bit_gateway_send_data->min_amount]);
		}
		if ($bit_gateway_send_data->max_amount && $bit_amount_send > $bit_gateway_send_data->max_amount) {
		    return response()->json(['success' => false, 'message' => "Maximum send amount is " . $bit_gateway_send_data->max_amount]);
		}

		// Validate minimum and maximum amount for receive gateway
		if ($bit_amount_receive < $bit_gateway_receive_data->min_amount) {
		    return response()->json(['success' => false, 'message' => "Minimum receive amount is " . $bit_gateway_receive_data->min_amount]);
		}
		if ($bit_gateway_receive_data->max_amount && $bit_amount_receive > $bit_gateway_receive_data->max_amount) {
		    return response()->json(['success' => false, 'message' => "Maximum receive amount is " . $bit_gateway_receive_data->max_amount]);
		}

		// Validate minimum and maximum amount for receive gateway
		if ($bit_amount_send > $bit_gateway_send_data->reserve) {
		    return response()->json(['success' => false, 'message' => "Our Reserve is less than your Send amount"]);
		}
		if ($bit_amount_receive > $bit_gateway_receive_data->reserve) {
		    return response()->json(['success' => false, 'message' => "Our Reserve is less than your Receive amount"]);
		}



		session()->put('transaction_data', [
	        'bit_amount_send' => $request->bit_amount_send,
	        'bit_amount_receive' => $request->bit_amount_receive,
	        'bit_rate_from' => $request->bit_rate_from,
	        'bit_rate_to' => $request->bit_rate_to,
	        'bit_gateway_send' => $request->bit_gateway_send,
	        'bit_gateway_receive' => $request->bit_gateway_receive,
	        'fees_txt' => $request->fees_txt,
	    ]);

		return response()->json(['success' => true, 'message' => "Exchange Successfully"]);

	}


	public function exchangeDetails(){
		return view('user.exchange');
	}


	public function exchangeDetailsSubmit(Request $request){

		$transactionData = session()->get('transaction_data');

	    if (!$transactionData) {
	    	return view('user.dashboard')->with('error',"No transaction data found in session.");
	    }

		DB::table('exchanges')->insert([
			"uid" => Auth::user()->id,
		    "amount_send" => $transactionData['bit_amount_send'],
		    "amount_receive" => $transactionData['bit_amount_receive'],
		    "rate_from" => $transactionData['bit_rate_from'],
		    "rate_to" => $transactionData['bit_rate_to'],
		    "gateway_send" => $transactionData['bit_gateway_send'],
		    "gateway_receive" => $transactionData['bit_gateway_receive'],
		    "fees" => $transactionData['fees_txt'],
		    "transaction_id" => $request->trxid,
		    "payeer_id" => $request->payeer_id,
		    "order_id" => rand(111111,999999),
		    "created" => now(),
		    "updated" => now()
		]);

		session()->forget('transaction_data');

		return redirect()->back()->with('success',"Order Successfully Submitted");

	}



}
