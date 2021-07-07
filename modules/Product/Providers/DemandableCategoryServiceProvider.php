<?php

namespace Modules\Product\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Modules\Product\Http\Controllers\DemandableCategoryController;
use Modules\Product\Models\Categories\DemandableCategory;
use Modules\Product\Services\DemandableCategoryService;
use Support\Interfaces\Services\IModelService;

class DemandableCategoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerDemandableCategoryServiceDependencies();
        $this->registerDemandableCategoryController();
    }

    public function registerDemandableCategoryController()
    {
        $this->app->when(DemandableCategoryController::class)
                  ->needs(IModelService::class)
                  ->give(DemandableCategoryService::class);
    }

    public function registerDemandableCategoryServiceDependencies()
    {
        $this->app->when(DemandableCategoryService::class)
                  ->needs(Model::class)
                  ->give(DemandableCategory::class);
    }
}
