<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::get('/admin/profile', [\App\Http\Controllers\DashboardController::class, 'profile'])->name('dashboard.profile');

Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
Route::post('/veriy', [AuthController::class, 'verify'])->name('auth.verify');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
