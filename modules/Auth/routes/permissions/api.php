<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('/permissions')->name('permissions.')->group(function () {
    Route::get('/', 'PermissionController@index')->name('index');
});
