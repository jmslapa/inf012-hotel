<?php

use Illuminate\Support\Facades\Route;

Route::name('customer.')->group(function () {
    Route::post('customer/{customer}/add-phone', 'CustomerController@addPhone')
        ->name('add-phone');
    Route::delete('customer/{customer}/remove-phone/{phone}', 'CustomerController@removePhone')
        ->name('remove-phone');
});
Route::apiResource('customer', 'CustomerController');
