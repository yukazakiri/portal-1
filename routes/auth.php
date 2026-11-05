<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Koamishin\Auth\Http\Controllers\AuthenticationController;

Route::get('login', fn (Request $request) => redirect()->route('koamishin.login', $request->query()))
    ->name('login');

Route::get('register', fn (Request $request) => redirect()->route('koamishin.register', $request->query()))
    ->name('register');

Route::get('forgot-password', fn (Request $request) => redirect()->route('koamishin.login', $request->query()))
    ->name('password.request');

Route::get('reset-password/{token}', fn () => redirect()->route('koamishin.login'))
    ->name('password.reset');

Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
