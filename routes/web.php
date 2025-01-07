<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('landingPage');
})->name('landingPage');

route::get('/signin', [AuthController::class, "signin"])->name('signin');
route::post('/signin', [AuthController::class, "signinPost"])->name('signin.post');
route::get('/signup', [AuthController::class, "signup"])->name('signup');
route::post('/signup', [AuthController::class, "signupPost"])->name('signup.post');

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Route untuk halaman permainan
Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/games/{level}', [GameController::class, 'show'])->name('games.show');
Route::post('/games/check-answer', [GameController::class, 'checkAnswer'])->name('games.checkAnswer');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

// Tahap Perbaikan
Route::get('/manage', [QuestionController::class, 'index'])->name('parent.manage');
Route::get('/create', [QuestionController::class, 'create'])->name('parent.create');
Route::post('/store', [QuestionController::class, 'store'])->name('parent.store');
Route::get('/edit/{id}', [QuestionController::class, 'edit'])->name('parent.edit');
Route::put('/update/{id}', [QuestionController::class, 'update'])->name('parent.update');
Route::delete('/destroy/{id}', [QuestionController::class, 'destroy'])->name('parent.destroy');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\AdminController::class, 'login'])->name('admin.login.post');
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');

    // Questions Management Routes
    Route::get('/questions/create', [App\Http\Controllers\AdminController::class, 'createQuestion'])->name('admin.questions.create');
    Route::post('/questions', [App\Http\Controllers\AdminController::class, 'storeQuestion'])->name('admin.questions.store');
    Route::get('/questions/{question}/edit', [App\Http\Controllers\AdminController::class, 'editQuestion'])->name('admin.questions.edit');
    Route::put('/questions/{question}', [App\Http\Controllers\AdminController::class, 'updateQuestion'])->name('admin.questions.update');
    Route::delete('/questions/{question}', [App\Http\Controllers\AdminController::class, 'destroyQuestion'])->name('admin.questions.destroy');
});
