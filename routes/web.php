<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function () {
    return view('auth.login'); 
});


Route::get('/register', function () {
    return view('auth.register'); 
});

Route::get('/dashboard', function () {
    return view('user.dashboard');
});


Route::get('/admin/dashboard', function () {

    return view('admin.dashboard');
});