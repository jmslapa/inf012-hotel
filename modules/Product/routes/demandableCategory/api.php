<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('demandable-category', 'DemandableCategoryController')
    ->parameters(['demandable-category' => 'category'])
    ->middleware('auth:sanctum');
