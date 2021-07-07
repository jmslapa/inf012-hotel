<?php

use Illuminate\Support\Facades\Route;

Route::name('booking.')->group(function () {
    Route::post('booking/{booking}/add-demandable', 'BookingController@addDemandable')
        ->name('add-demandable');
    Route::delete('booking/{booking}/remove-demandable/{demandable}', 'BookingController@removeDemandable')
        ->name('remove-demandable');
    Route::patch('booking/{booking}/check-in', 'BookingController@checkIn')
        ->name('check-in');
    Route::patch('booking/{booking}/check-out', 'BookingController@checkOut')
        ->name('check-out');
});
Route::apiResource('booking', 'BookingController');
