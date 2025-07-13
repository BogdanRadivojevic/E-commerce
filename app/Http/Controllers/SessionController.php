<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create(){
        return view("auth.login");
    }

    public function store(){
        // validate
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!Auth::attempt($attributes)){
            throw ValidationException::withMessages([
                'email' => __('auth.failed')
            ]);
        }

        // regenerate the session token
        request()->session()->regenerate();

        return redirect('/')->with('success', 'Welcome back, ' . Auth::user()->name . '!');
    }

    public function destroy(){
        Auth::logout();

        return redirect('/')->with('success', 'You have been logged out!');
    }
}
