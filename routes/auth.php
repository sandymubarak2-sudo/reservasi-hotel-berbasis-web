<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// 1. RUTE UNTUK MENAMPILKAN FORMULIR VISUAL (GET)
Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return view('auth.register'); // Kita akan buat file ini di langkah ke-2
    })->name('register');

    Route::get('/login', function () {
        return view('auth.login'); // Kita akan buat file ini di langkah ke-2
    })->name('login');
});

// 2. RUTE UNTUK MEMPROSES DATA DARI FORMULIR (POST)
Route::middleware('guest')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// 3. RUTE UNTUK KELUAR/LOGOUT (Hanya bisa diklik jika sudah login)
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');