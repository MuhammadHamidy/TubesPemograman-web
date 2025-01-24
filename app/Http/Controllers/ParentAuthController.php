<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ParentAuthController extends Controller
{
    public function showParentLogin()
    {
        return view('auth.parent-login');
    }

    public function parentLogin(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required',
            'mother_name' => 'required|string'
        ]);

        $child = User::where('name', $request->name)->first();
        
        if (!$child) {
            return back()->withErrors(['name' => 'Nama anak tidak ditemukan']);
        }

        if (!Hash::check($request->password, $child->password)) {
            return back()->withErrors(['password' => 'Kata sandi anak tidak valid']);
        }

        if ($child->mother_name !== $request->mother_name) {
            return back()->withErrors(['mother_name' => 'Nama ibu kandung tidak valid']);
        }

        // Create parent user session
        Auth::login($child);
        return redirect()->route('profile');
    }
}
