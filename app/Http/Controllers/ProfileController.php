<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Assuming you're using authentication
        // Or you can create a mock user for testing:
        $user = (object)[
            'name' => 'Haikal Putra A.H',
            'points' => 0
        ];

        return view('profile.index', compact('user'));
    }
}