<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return redirect()->route('signin')->with("error","Login gagal. Periksa kembali kredensial Anda.");
    }

    // Handle Signup POST Request
    public function signupPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'age' => 'required|integer|max:255',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $data['name'] =  $request->name;
        $data['mother_name'] =  $request->mother_name;
        $data['age'] =  $request->age;
        $data['password'] =  Hash::make($request->password);
        $data['role'] = $request->role; // Assign role

        $user = User::create($data);

        if(!$user){
            return redirect()->route('signup')->with("error","Registrasi gagal. Silakan coba lagi.");
        }

        return redirect(route('signin'))->with('success', 'Registrasi berhasil. Silakan login.');
    }
}
