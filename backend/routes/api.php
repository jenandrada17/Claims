<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ping', fn() => ['ok' => true, 'time' => now()->toDateTimeString()]);

// NEWLY ADDED
Route::post('/login', function (Request $r) {
    $r->validate(['email' => 'required|email', 'password' => 'required']);

    if (!Auth::attempt($r->only('email', 'password'), $r->boolean('remember'))) {
        return response()->json(['message' => 'Invalid credentials'], 422);
    }

    $r->session()->regenerate();

    return response()->json(['message' => 'ok']);
})->middleware('throttle:login');   // 👈 add this

Route::post('/logout', function (Request $r) {
    Auth::guard('web')->logout();
    $r->session()->invalidate();
    $r->session()->regenerateToken();
    return response()->json(['message' => 'ok']);
});

// Route::get('/me', fn(Request $r) => $r->user())->middleware('auth:sanctum');

Route::get('/me', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');