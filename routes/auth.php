<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Koamishin\Auth\Http\Controllers\AuthenticationController;
use Koamishin\Auth\KoamishinAuth;

Route::get('login', function (Request $request) {
    if ($request->header('X-Inertia')) {
        $auth = app(KoamishinAuth::class);
        $url = $auth->getLoginUrl($request->query('return_to'));

        return response('', 409)->header('X-Inertia-Location', $url);
    }

    return redirect()->route('koamishin.login', $request->query());
})->name('login');

Route::get('register', function (Request $request) {
    if ($request->header('X-Inertia')) {
        $auth = app(KoamishinAuth::class);
        $url = $auth->getRegistrationUrl($request->query('return_to'));

        return response('', 409)->header('X-Inertia-Location', $url);
    }

    return redirect()->route('koamishin.register', $request->query());
})->name('register');

Route::get('forgot-password', fn (Request $request) => redirect()->route('koamishin.login', $request->query()))
    ->name('password.request');

Route::get('reset-password/{token}', fn () => redirect()->route('koamishin.login'))
    ->name('password.reset');

Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
