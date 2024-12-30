<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Landing Page Route
Route::get('/', function () {
    return view('landingPage');
})->name('landingPage');

// Authentication Routes
Route::get('/signin', [AuthController::class, "signin"])->name('signin');
Route::post('/signin', [AuthController::class, "signinPost"])->name('signin.post');
Route::get('/signup', [AuthController::class, "signup"])->name('signup');
Route::post('/signup', [AuthController::class, "signupPost"])->name('signup.post');

// Home Route (to be implemented later)
Route::get('/home', [AuthController::class, "home"])->name('home')->middleware('auth');
