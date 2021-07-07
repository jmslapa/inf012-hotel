<?php

namespace Modules\Product\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Modules\Product\Http\Controllers\RentableController;
use Modules\Product\Interfaces\Services\IRentableService;
use Modules\Product\Models\Products\Rentable;
use Modules\Product\Services\RentableService;

class RentableServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerRentableServiceDependencies();
        $this->registerRentableControllerDependencies();
    }

    public function registerRentableControllerDependencies()
    {
        $this->app->when(RentableController::class)
                  ->needs(IRentableService::class)
                  ->give(RentableService::class);
    }

    public function registerRentableServiceDependencies()
    {
        $this->app->when(RentableService::class)
                  ->needs(Model::class)
                  ->give(Rentable::class);
    }
}
