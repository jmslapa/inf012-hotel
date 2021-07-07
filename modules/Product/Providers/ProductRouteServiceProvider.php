<?php

namespace Modules\Product\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class ProductRouteServiceProvider extends RouteServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Modules\Product\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapRentableApiRoutes();
        $this->mapRentableCategoryApiRoutes();
        $this->mapDemandableApiRoutes();
        $this->mapDemandableCategoryApiRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapRentableApiRoutes()
    {
        Route::prefix('api/product')
            ->middleware('api')
            ->namespace($this->namespace)
            ->name('api.product.')
            ->group(base_path('modules/Product/routes/rentable/api.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapRentableCategoryApiRoutes()
    {
        Route::prefix('api/product')
            ->middleware('api')
            ->namespace($this->namespace)
            ->name('api.product.')
            ->group(base_path('modules/Product/routes/rentableCategory/api.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapDemandableApiRoutes()
    {
        Route::prefix('api/product')
            ->middleware('api')
            ->namespace($this->namespace)
            ->name('api.product.')
            ->group(base_path('modules/Product/routes/demandable/api.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapDemandableCategoryApiRoutes()
    {
        Route::prefix('api/product')
            ->middleware('api')
            ->namespace($this->namespace)
            ->name('api.product.')
            ->group(base_path('modules/Product/routes/demandableCategory/api.php'));
    }
}
