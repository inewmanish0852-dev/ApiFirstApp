<?php
// app/Http/Controllers/Admin/AuthController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function adminLogin()
    {  
        $email = "admin@myapp.com";
        $password = "password";

        $adminEmail = "admin@myapp.com";
        $adminPassword = "password";

        if ($email === $adminEmail && $password === $adminPassword) {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard')->with('success','Admin Login Successful');
        }

        return back()->with('error','Invalid credentials');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}