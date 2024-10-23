<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle the login request
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'user_type' => 'required|in:distributor,supervisor,factory',
        ]);

        $credentials = $request->only('email', 'password');
        $userType = $request->input('user_type');

        // Determine the guard based on user type
        switch ($userType) {
            case 'distributor':
                if (Auth::guard('distributor')->attempt($credentials)) {
                    return redirect()->route('distributor.dashboard');
                }
                break;

            case 'supervisor':
                if (Auth::guard('supervisor')->attempt($credentials)) {
                    return redirect()->route('supervisor.dashboard');
                }
                break;

            case 'factory':
                if (Auth::guard('factory')->attempt($credentials)) {
                    return redirect()->route('factory.dashboard');
                }
                break;
        }

        // If authentication fails
        return back()->withErrors([
            'email' => 'Invalid credentials or user type.',
        ])->withInput($request->only('email', 'user_type'));
    }

    // Handle logout for all guards
    public function logout(Request $request)
    {
        if (Auth::guard('distributor')->check()) {
            Auth::guard('distributor')->logout();
        } elseif (Auth::guard('supervisor')->check()) {
            Auth::guard('supervisor')->logout();
        } elseif (Auth::guard('factory')->check()) {
            Auth::guard('factory')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
