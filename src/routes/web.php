<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\AuthService;

Route::get('/', function () {
    $auth = new AuthService();
    return $auth->checkStatus();
});
