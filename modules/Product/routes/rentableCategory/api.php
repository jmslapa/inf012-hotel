<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('rentable-category', 'RentableCategoryController')
    ->parameters(['rentable-category' => 'category'])
    ->middleware('auth:sanctum');
