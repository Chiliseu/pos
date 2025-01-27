<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Transaction;

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
        $loginAttempts = session()->get('loginAttempts', 0);
        return view('login', compact('loginAttempts'));
    }

    // Resets the login attempts
    public function resetLoginAttempts()
    {
        session()->forget('loginAttempts');
        return response()->json(['status' => 'success']);
    }

    // Checks if the user is authenticated
    public function authenticate(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Track login attempts
        $loginAttempts = session()->get('loginAttempts', 0);

        // Check if login attempts exceed the limit
        if ($loginAttempts >= 5) {
            return redirect()->back()->withErrors(['Too many login attempts. Please try again later.']);
        }

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Regenerate session to prevent session fixation attacks
            $request->session()->regenerate();
            session()->forget('loginAttempts');

            // Check if the authenticated user is an admin
            if (Auth::user()->UserRoleID == 2) {
                // Pass data to the view
                return view('admin-menu');
            }

            return redirect()->intended('/staff-menu'); // Redirect to the intended page or dashboard
        }

        // Increment login attempts
        session()->put('loginAttempts', $loginAttempts + 1);

        // Redirect back with an error
        if ($loginAttempts < 4) {
            return back()->withErrors([
                'email' => "The provided credentials do not match our records. Please try again.",
            ]);
        } else {
            return back()->withErrors([
                'email' => "Too many login attempts. Please try again later.",
            ]);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Redirect to login page
    }
}
