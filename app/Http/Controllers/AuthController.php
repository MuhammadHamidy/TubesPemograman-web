<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ParentChildRelationship;

class AuthController extends Controller
{
    // Show Signin Form
    public function signin()
    {
        return view('auth.signin');
    }

    // Show Signup Form
    public function signup()
    {
        return view('auth.signup');
    }

    // Handle Signin POST Request
    public function signinPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Handle Signup POST Request
    public function signupPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'mother_name' => 'required|string|max:255',
            'age' => 'required|integer|max:255',
            'parent_password' => 'required|string|min:6'
        ]);

        // Buat akun anak
        $child = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'mother_name' => $request->mother_name,
            'role' => 'child'
        ]);

        // Buat akun orang tua
        $parent = User::create([
            'name' => $request->mother_name,
            'username' => 'parent_' . $request->username,
            'password' => Hash::make($request->parent_password),
            'role' => 'parent'
        ]);

        // Buat relasi parent-child
        ParentChildRelationship::create([
            'parent_id' => $parent->id,
            'child_id' => $child->id
        ]);

        return redirect()->route('signin')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Handle Logout Request
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landingPage')->with('success', 'Berhasil logout!');
    }
}
