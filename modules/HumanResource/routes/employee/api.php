<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('employees', 'EmployeeController')->middleware('auth:sanctum');
