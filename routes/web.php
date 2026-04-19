<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user-dashboard', [UserController::class, 'dashboard'])
    ->name('user-dashboard');
 
Route::get('/user-profile', [UserController::class, 'profile'])
    ->name('user-profile');  

Route::get('/user-link', [UserController::class, 'link'])
    ->name('user-link');  

Route::get('/test', function () {
    return view('user.dashboard');
});

Route::get('/user-profile', function () {
    return view('user.profile'); 
})->name('user-profile');

// routes/web.php

Route::get('/uesr-dashboard', function () {
    return view('user.dashboard');
})->name('user.dashboard');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login'); 
});  

Route::get('/register', function () {
    return view('auth.register'); 
});

Route::get('/test', function () {
    return view('user.profile');
});

Route::get('/uesr-link', function () {
    return view('user.link');
})->name('user.link');

