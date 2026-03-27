<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

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

    // Menampilkan form forgot password
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Mengirim link reset password ke email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    // Menampilkan form reset password
    public function showResetPassword(Request $request, $token)
    {
        return view('auth.reset-password', ['request' => $request, 'token' => $token]);
    }

    // Memproses form reset password menjadi password baru
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect('/login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
