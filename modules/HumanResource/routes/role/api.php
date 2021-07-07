<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('roles', 'RoleController')->middleware('auth:sanctum');
