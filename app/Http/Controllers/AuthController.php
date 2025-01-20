<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register'); // Return your registration view
    }

    public function registerUser(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create user
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Redirect to login or auto-login the user
        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }
    public function login()
    {
        return view('login'); // Return your login view
    }


    //checks if the user is authenticated
    public function authenticate(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Regenerate session to prevent session fixation attacks
            $request->session()->regenerate();
    
            // Check if the authenticated user is an admin
            if (Auth::user()->UserRoleID == 2) {
                return redirect()->intended('/admin-menu'); // Redirect to admin dashboard
            }
    
            return redirect()->intended('/staff-menu'); // Redirect to the intended page or dashboard
        }
    
        // Redirect back with an error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Redirect to login page
    }


}


//Testing Hello