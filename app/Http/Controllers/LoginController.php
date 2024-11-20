<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        $credentials['email'] = $credentials['login'];
        unset($credentials['login']);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $token = $request->user()->createToken('api-token')->plainTextToken;

            return redirect('/')->withCookie(cookie('token', $token, 60));
        }

        return back()->withErrors([
            'login' => 'Invalid credentials'
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}
