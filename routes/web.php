<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Two\GithubProvider;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('login/github', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGithub'])->name("login.github");
Route::get('login/github/callback', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGithub']);


Route::get('login/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name("login.google");
Route::get('login/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle']);


Route::get('login/facebook', [App\Http\Controllers\Auth\LoginController::class, 'redirectToFacebook'])->name("login.facebook");
Route::get('login/facebook/callback', [App\Http\Controllers\Auth\LoginController::class, 'redirectToFacebook']);
