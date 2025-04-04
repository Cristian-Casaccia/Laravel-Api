<?php

use App\Http\Controllers\Api\AuthController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function() {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::get('user-profile', 'userProfile')->middleware('auth:sanctum');
    Route::get('/validate-token', 'validateToken');
    Route::get('logout', 'logout')->middleware('auth:sanctum');
});
