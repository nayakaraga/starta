<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $minutesExpiration = 43200; //equivalent of 30 days

    public function login()
    {
        // dd('asdasd');
        return view('pages/auth/login');
    }


    public function authenticate(Request $request)
    {
        if (
            Auth::attempt([
                'username' => $request['email'],
                'password' => $request['password']
            ])
            ||
            Auth::attempt([
                'email' => $request['email'],
                'password' => $request['password']
            ])
        ) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('error', 'Login Failed!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
