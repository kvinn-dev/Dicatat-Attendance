<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Method untuk menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login'); // pastikan ada file resources/views/auth/login.blade.php
    }

    // Method untuk proses login (opsional)
    public function login(Request $request)
    {
        // validasi input
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function logout()
    {
        Auth::logout();       // logout user
        request()->session()->invalidate(); // clear session
        request()->session()->regenerateToken(); // CSRF token baru

        return redirect('/login'); // redirect ke login page
    }
}
