<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ParentController;

Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    
    // Landing page route yang membutuhkan auth
    Route::get('/landing', function () {
        $user = Auth::user();
        return view('landingPage', compact('user'));
    })->name('landing');
});

// Public routes
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return view('landingPage', compact('user'));
    }
    return view('landingPage');
})->name('landingPage');


route::get('/signin', [AuthController::class, "signin"])->name('signin');
route::post('/signin', [AuthController::class, "signinPost"])->name('signin.post');
route::get('/signup', [AuthController::class, "signup"])->name('signup');
route::post('/signup', [AuthController::class, "signupPost"])->name('signup.post');
route::post('/logout', [AuthController::class, "logout"])->name('logout');

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

// Authentication Routes
Route::get('/login', function () {
    return view('auth.signin');
})->name('login');
Route::post('/login', [AuthController::class, 'signinPost'])->name('auth.signin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Tutorial Video Management
    Route::get('/admin/tutorial-video', [AdminController::class, 'tutorialVideo'])->name('admin.tutorial.video');
    Route::post('/admin/tutorial-video', [AdminController::class, 'storeTutorialVideo'])->name('admin.tutorial.store');
    Route::put('/admin/tutorial-video/{id}', [AdminController::class, 'updateTutorialVideo'])->name('admin.tutorial.update');
    Route::delete('/admin/tutorial-video/{id}', [AdminController::class, 'deleteTutorialVideo'])->name('admin.tutorial.delete');
    Route::post('/admin/tutorial-video/{id}/activate', [AdminController::class, 'activateTutorialVideo'])->name('admin.tutorial.activate');
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    Route::middleware(['admin'])->group(function () {
        // ... existing admin routes ...
    });
});

// Parent routes
Route::middleware(['auth', 'role:parent'])->group(function () {
    Route::get('/parent/manage', [ParentController::class, 'manage'])->name('parent.manage');
    Route::get('/parent/child/{id}/progress', [ParentController::class, 'viewChildProgress'])->name('parent.child-progress');
    Route::post('/parent/link-child', [ParentController::class, 'linkChild'])->name('parent.link-child');
});

// Parent authentication routes
Route::get('/parent/signin', [ParentController::class, 'showSignin'])->name('parent.signin');
Route::post('/parent/signin', [ParentController::class, 'signin'])->name('parent.signin.post');

// Parent protected routes
Route::middleware(['auth', 'role:parent'])->group(function () {
    Route::get('/parent/manage', [ParentController::class, 'manage'])->name('parent.manage');
    Route::get('/parent/child/{id}/progress', [ParentController::class, 'viewChildProgress'])->name('parent.child-progress');
});
