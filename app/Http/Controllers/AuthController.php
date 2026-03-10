<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
        {
            $cradential = $request->only('email','password');
            $rememberme = $request->has('remember') ? true : false;
            if (Auth::guard('admin')->attempt($cradential, $rememberme)) {
                return redirect()->intended(route('dashboard'));
            } else {
                return redirect()->back()->withErrors("Email or Password does not match");
            }
        }

}
