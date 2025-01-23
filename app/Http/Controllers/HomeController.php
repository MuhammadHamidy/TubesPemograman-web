<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TutorialVideo;

class HomeController extends Controller
{
    public function index()
    {
        $tutorialVideo = TutorialVideo::where('is_active', true)->first();
        return view('home_game', compact('tutorialVideo'));
    }
    
}
