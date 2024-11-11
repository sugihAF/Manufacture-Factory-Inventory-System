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
        ]);

        $credentials = $request->only('email', 'password');

        // Detect user type based on email pattern
        $userType = null;
        $email = $request->input('email');

        if (str_contains($email, 'supervisor')) {
            $userType = 'supervisor';
        } elseif (str_contains($email, 'distributor')) {
            $userType = 'distributor';
        } elseif (str_contains($email, 'factory')) {
            $userType = 'factory';
        } else {
            return back()->withErrors([
                'email' => 'User type could not be determined from email.',
            ])->withInput($request->only('email'));
        }

        // Attempt login based on detected user type
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
        ])->withInput($request->only('email'));
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
