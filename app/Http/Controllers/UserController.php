<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard() {
    return view('user.dashboard');
}
    public function profile() {
    return view('user.profile');
}
    public function link() {
    return view('user.link');
}

}

