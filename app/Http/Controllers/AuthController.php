<?php

namespace Expose\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        if (\Auth::attempt($request->only(['username', 'password']))) {
            return redirect()->intended(route('Dashboard'));
        } else {
            return view('auth.login')->with('failed', true);
        }
    }
}