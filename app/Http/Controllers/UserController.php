<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function register(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/'
                ],
            ],
            [
                'email.uniquie' => 'Invalid email address - Please enter a valid email address.',
                'password.min' => 'Password does not meet requirements - Your password must be at least 8 characters long',
                'password.regex' => 'Password does not meet requirements - Your password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number.',
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('user', Auth::user());
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('home')->with('user', Auth::user());
        }

        return back()->withErrors([
            'email' => 'As credenciais estão incorretas.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
