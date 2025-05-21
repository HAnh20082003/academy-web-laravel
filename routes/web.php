<?php

use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckLogin;
use App\Http\Middleware\Login;
use App\Http\Middleware\NoCache;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(CheckLogin::class)->group(function () {

    Route::prefix('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
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
    session()->forget('user_login');
    cookie()->queue(cookie()->forget('user_login'));
    return redirect('/login');
})->name('logout');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.email');
Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('password.verifyForm');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('password.verify');
