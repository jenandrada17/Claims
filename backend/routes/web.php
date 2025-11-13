<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/login', function (Request $r) {
    $r->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($r->only('email', 'password'), $r->boolean('remember'))) {
        // generic error to avoid information leak
        return response()->json(['message' => 'Invalid credentials'], 422);
    }

    $r->session()->regenerate(); // prevent session fixation

    return response()->json(['message' => 'ok']);
})->middleware('throttle:login'); // keep your login rate limit