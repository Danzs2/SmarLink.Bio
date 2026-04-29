<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController; 

Route::get('/', function () {
    return view('welcome');
});

// --- BAGIAN DASHBOARD (DIPROTEKSI SATPAM/AUTH) ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard User (Pintu utama yang bisa membedakan role)
    Route::get('/dashboard', function () {
        // Jika yang masuk adalah admin, paksa pindah ke markas admin
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        return view('user.dashboard');
    })->name('dashboard');

    
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->middleware('is_admin')->name('admin.dashboard');

    // Fitur Edit Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';