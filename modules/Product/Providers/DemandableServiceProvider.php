<?php

namespace Modules\Product\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Modules\Product\Http\Controllers\DemandableController;
use Modules\Product\Models\Products\Demandable;
use Modules\Product\Services\DemandableService;
use Support\Interfaces\Services\IModelService;

class DemandableServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerDemandableServiceDependencies();
        $this->registerDemandableControllerDependencies();
    }

    public function registerDemandableControllerDependencies()
    {
        $this->app->when(DemandableController::class)
                  ->needs(IModelService::class)
                  ->give(DemandableService::class);
    }

    public function registerDemandableServiceDependencies()
    {
        $this->app->when(DemandableService::class)
                  ->needs(Model::class)
                  ->give(Demandable::class);
    }
}
