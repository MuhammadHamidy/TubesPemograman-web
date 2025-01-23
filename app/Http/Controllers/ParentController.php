<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ParentChildRelationship;
use Illuminate\Support\Facades\Hash;

class ParentController extends Controller
{
    public function manage()
    {
        $parent = Auth::user();
        
        // Ambil semua anak yang terkait dengan orang tua ini
        $children = User::whereHas('parentRelationships', function($query) use ($parent) {
            $query->where('parent_id', $parent->id);
        })->get();

        return view('parent.manage', compact('children'));
    }

    public function viewChildProgress($childId)
    {
        $parent = Auth::user();
        
        // Verifikasi bahwa anak ini memang terkait dengan orang tua yang sedang login
        $child = User::whereHas('parentRelationships', function($query) use ($parent) {
            $query->where('parent_id', $parent->id);
        })->findOrFail($childId);

        return view('parent.child-progress', compact('child'));
    }

    public function linkChild(Request $request)
    {
        $request->validate([
            'child_email' => 'required|email|exists:users,email'
        ]);

        $parent = Auth::user();
        $child = User::where('email', $request->child_email)
                    ->where('role', 'child')
                    ->firstOrFail();

        // Buat relasi parent-child
        ParentChildRelationship::create([
            'parent_id' => $parent->id,
            'child_id' => $child->id
        ]);

        return redirect()->route('parent.manage')
                        ->with('success', 'Berhasil menghubungkan dengan akun anak');
    }

    public function showSignin()
    {
        return view('parent.signin');
    }

    public function signin(Request $request)
    {
        $request->validate([
            'child_username' => 'required|string',
            'password' => 'required'
        ]);

        // Cari anak berdasarkan username
        $child = User::where('username', $request->child_username)
                    ->where('role', 'child')
                    ->first();

        if (!$child) {
            return back()->with('error', 'Akun anak tidak ditemukan');
        }

        // Cari akun orang tua yang terkait
        $parent = User::whereHas('children', function($query) use ($child) {
            $query->where('child_id', $child->id);
        })->where('role', 'parent')->first();

        if (!$parent || !Hash::check($request->password, $parent->password)) {
            return back()->with('error', 'Password orang tua tidak sesuai');
        }

        // Login sebagai orang tua
        Auth::login($parent);

        return redirect()->route('parent.manage');
    }
} 