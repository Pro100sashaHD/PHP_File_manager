<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return "Привет, " . Auth::user()->name . "! Вы успешно вошли.";
    }
    return view('welcome');
});

Route::get('/home', function () {
    return redirect('/');
});
