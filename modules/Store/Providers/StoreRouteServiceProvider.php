<?php

namespace Modules\Store\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class StoreRouteServiceProvider extends RouteServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Modules\Store\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapCustomerApiRoutes();
        $this->mapBookingApiRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */

    protected function mapCustomerApiRoutes()
    {
        Route::prefix('api/store')
        ->middleware('api')
        ->namespace($this->namespace)
        ->name('api.store.')
        ->group(base_path('modules/Store/routes/customer/api.php'));
    }

    protected function mapBookingApiRoutes()
    {
        Route::prefix('api/store')
        ->middleware('api')
        ->namespace($this->namespace)
        ->name('api.store.')
        ->group(base_path('modules/Store/routes/booking/api.php'));
    }
}
