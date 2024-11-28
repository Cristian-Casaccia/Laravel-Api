<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\OpenBrewController;
use App\Http\Middleware\EnsureTokenIsValid;
use App\Http\Middleware\TokenIsValid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('login');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/bearer', function () {
    return view('bearer');
});
Route::post('breweries', [OpenBrewController::class, 'GuzzlefetchBreweries']);
