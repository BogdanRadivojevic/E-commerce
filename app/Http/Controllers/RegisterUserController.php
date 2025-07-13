<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterUserController extends Controller
{
    public function create(){
        return view("auth.register");
    }

    public function store(){
        $validatedAttributes = request()->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],// email_confirmation from html
            'password' => ['required', Password::min(6), 'confirmed'], // password_confirmation from html
            'role' => ['required', 'in:admin,customer'],
        ]);

        // Map role name to role_id
        $role = Role::where('name', $validatedAttributes['role'])->firstOrFail();
        $validatedAttributes['role_id'] = $role->id;
        unset($validatedAttributes['role']);

        // create the user
        $user = User::create($validatedAttributes);

        // log in
        Auth::login($user);

        // redirect somewhere
        return redirect('/');
    }

    public function destroy(){
        // Ensure the user is authenticated
        $user = Auth::user();

        if ($user) {
            // Delete the authenticated user
            $user->delete();

            // Log the user out
            Auth::logout();

            // Redirect to the homepage with a success message
            return redirect('/')->with('message', 'Your account has been deleted successfully.');
        }

        // If no authenticated user, redirect with an error message
        return redirect('/')->with('error', 'Unable to delete account. Please try again.');

    }
}
