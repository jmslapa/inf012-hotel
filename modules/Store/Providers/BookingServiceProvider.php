<?php

namespace Modules\Store\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Modules\Store\Http\Controllers\BookingController;
use Modules\Store\Models\Booking;
use Modules\Store\Services\BookingService;
use Support\Interfaces\Services\IModelService;

class BookingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerBookingServiceDependencies();
        $this->registerBookingConrtrollerDependencies();
    }

    public function registerBookingConrtrollerDependencies()
    {
        $this->app->when(BookingController::class)
                  ->needs(IModelService::class)
                  ->give(BookingService::class);
    }

    public function registerBookingServiceDependencies()
    {
        $this->app->when(BookingService::class)
                  ->needs(Model::class)
                  ->give(Booking::class);
    }
}
