<?php

use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckLogin;
use App\Http\Middleware\Login;
use App\Http\Middleware\NoCache;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(CheckLogin::class)->prefix('admin')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/get/{id}', [UserController::class, 'get'])->name('admin.users.get');
        Route::post('/store', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('/mass-destroy', [UserController::class, 'massDestroy'])->name('admin.users.massDestroy');
    });
});


Route::get('/test', function () {
    return view('test');
});

Route::get('/uitest', function () {
    return view('user-test');
});

//login logout sign up
Route::get('/login', function () {
    return view('pages.login');
})->middleware([RedirectIfAuthenticated::class, NoCache::class])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/logout', function () {
    Auth::logout();
    cookie()->queue(cookie()->forget('user_login'));
    return redirect('/login');
})->name('logout');

Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.email');
Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('password.verifyForm');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('password.verify');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
// Chuyển hướng đến Facebook
Route::get('/auth/facebook', [AuthController::class, 'redirectToFacebook'])->name('facebook.login')->middleware('web');
Route::get('/auth/facebook/callback', [AuthController::class, 'handleFacebookCallback'])->middleware('web');
