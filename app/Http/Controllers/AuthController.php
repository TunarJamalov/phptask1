<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('books.index')->with('success', 'Uğurla qeydiyyatdan keçdiniz!');
    }

    public function showLogin()
    {
        return view('admin_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            if (!auth()->user()->is_active) {
                auth()->logout();
                return back()->withErrors(['email' => 'Hesabınız admin tərəfindən bloklanıb!']);
            }
            $request->session()->regenerate();
            return redirect()->intended('books')->with('success', 'Sistemə daxil oldunuz!');
        }

        return back()->withErrors([
            'email' => 'Daxil etdiyiniz məlumatlar yalnışdır.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
