<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserAuthController extends Controller
{
    public function index(){
        return view('user.index');
    }

    public function login(){
        return view('user.login');
    }

    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(){
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt('password'), // Default password (not recommended in production)
                ]);
            }

            // Login user
            Auth::login($user);

            return redirect()->intended(route('user.dashboard'));
        } catch (\Exception $e) {
            return redirect()->route('user.login')->with('error', 'Something went wrong!');
        }
    }
}
