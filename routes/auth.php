<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('register', 'Pages.auth.register')
        ->name('register');

    Volt::route('login', 'Pages.auth.login')
        ->name('login');

    Volt::route('forgot-password', 'Pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'Pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'Pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'Pages.auth.confirm-password')
        ->name('password.confirm');
});
