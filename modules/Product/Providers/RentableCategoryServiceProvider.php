<?php

namespace Modules\Product\Providers;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Http\Controllers\RentableCategoryController;
use Modules\Product\Models\Categories\RentableCategory;
use Modules\Product\Services\RentableCategoryService;
use Support\Interfaces\Services\IModelService;

class RentableCategoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerRentableCategoryServiceDependencies();
        $this->registerRentableCategoryControllerDependencies();
    }

    public function registerRentableCategoryControllerDependencies()
    {
        $this->app->when(RentableCategoryController::class)
                  ->needs(IModelService::class)
                  ->give(RentableCategoryService::class);
    }

    public function registerRentableCategoryServiceDependencies()
    {
        $this->app->when(RentableCategoryService::class)
                  ->needs(Model::class)
                  ->give(RentableCategory::class);
    }
}
