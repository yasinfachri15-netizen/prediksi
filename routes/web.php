<?php

use App\Http\Controllers\AdminModelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:admin,dosen'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/mahasiswa', [DashboardController::class, 'storeMahasiswa'])->name('mahasiswa.store');
    Route::put('/mahasiswa/{mahasiswa}', [DashboardController::class, 'updateMahasiswa'])->name('mahasiswa.update');
    Route::delete('/mahasiswa/{mahasiswa}', [DashboardController::class, 'destroyMahasiswa'])->name('mahasiswa.destroy');
    Route::post('/simulasi', [DashboardController::class, 'simulasi'])->name('simulasi');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/latih', [AdminModelController::class, 'train'])->name('train');
    Route::post('/data-latih', [AdminModelController::class, 'storeLatih'])->name('latih.store');
    Route::delete('/data-latih/{latih}', [AdminModelController::class, 'destroyLatih'])->name('latih.destroy');
});