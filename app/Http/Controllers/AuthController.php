<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Menampilkan form signup
    public function showSignupForm()
    {
        return view('signup');
    }

    // Proses signup
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false
        ]);

        if ($user->is_admin === false) {
            Customer::create([
                'user_id' => $user->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'orders' => 0,
                'last_order' => Date::now()
            ]);
        }

        return redirect()->route('login')->with('success', 'Registration successful, please log in.');
    }

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Check if user is admin
            if (Auth::user()->is_admin) {
                return redirect()->route('dashboard'); // Admin dashboard
            } else {
                return redirect()->route('user.dashboard'); // User dashboard
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    // Proses logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
