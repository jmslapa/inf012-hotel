<?php

use Illuminate\Support\Facades\Route;

Route::post('/login', 'AuthController@login')->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/me', 'AuthController@me')->name('me');
    Route::post('/logout', 'AuthController@logout')->name('logout');
});
