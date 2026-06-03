<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\LinkController;
use App\Http\Controllers\AdminController; // Pastikan controller ini ada

Route::get('/', function () {
    return view('welcome');
});

// --- RUTE PUBLIK (Bisa diakses siapa saja) ---
Route::get('/@{username}', [LinkController::class, 'showProfile'])->name('profile.show');
Route::get('/go/{id}', [LinkController::class, 'redirect'])->name('link.go');
Route::post('/go/{id}/verify', [LinkController::class, 'verify'])->name('link.verify');

// --- RUTE TERPROTEKSI (Login Dulu) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Logika Pindah Role (Redirect ke Dashboard Admin atau User)
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('dashboard');

    // 2. Rute Admin
    Route::middleware(['is_admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        // Nanti tambah rute manajemen user di sini
    });

    // 3. Rute User (Link & Appearance)
    Route::get('/user/dashboard', [LinkController::class, 'index'])->name('user.dashboard');
    Route::post('/links/store', [LinkController::class, 'store'])->name('links.store');
    Route::put('/links/{id}', [LinkController::class, 'update'])->name('links.update');
    Route::delete('/links/{id}', [LinkController::class, 'destroy'])->name('links.destroy');
    Route::patch('/links/{id}/toggle', [LinkController::class, 'toggle'])->name('links.toggle');
    Route::post('/appearance/update', [LinkController::class, 'updateAppearance'])->name('appearance.update');

    // 4. Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/admin/users', [App\Http\Controllers\AdminController::class, 'store']);
Route::put('/admin/users/{id}', [App\Http\Controllers\AdminController::class, 'update']);
});

require __DIR__.'/auth.php';