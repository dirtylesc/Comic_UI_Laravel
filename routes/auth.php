<?php

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/process_login', [AuthController::class, 'processLogin'])->name('process_login');

Route::get('/form_confirm_password', [AuthController::class, 'formConfirmPassword'])
    ->middleware('auth')
    ->name('form_confirm_password');
Route::post('/confirm_new_password', [AuthController::class, 'confirmNewPassword'])
    ->middleware('auth')
    ->name('confirm_new_password');

Route::get('/email/verify', function () {
    return view('clients.auth.form_confirm_password');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirectTo();
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/auth/redirect/{provider}', function ($provider) {
    return Socialite::driver($provider)->redirect();
})->name('auth.redirect');
Route::get('auth/callback/{provider}', [AuthController::class, 'callback'])->name('auth.callback');
