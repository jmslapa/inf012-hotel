<?php

use Illuminate\Support\Facades\Route;

Route::name('rentable.')->middleware('auth:sanctum')->group(function () {
    Route::post('rentable/{rentable}/upload-images', 'RentableController@uploadImages')
        ->name('upload-images');
    Route::delete('rentable/{rentable}/remove-images', 'RentableController@removeImages')
        ->name('remove-images');
});
Route::apiResource('rentable', 'RentableController');
