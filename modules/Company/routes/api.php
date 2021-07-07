<?php

use Illuminate\Support\Facades\Route;

Route::name('company.')->group(function () {
    Route::post('company/{company}/add-phone', 'CompanyController@addPhone')
        ->name('add-phone');
    Route::delete('company/{company}/remove-phone/{phone}', 'CompanyController@removePhone')
        ->name('remove-phone');
});
Route::apiResource('company', 'CompanyController');
