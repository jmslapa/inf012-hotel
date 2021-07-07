<?php

namespace Modules\Auth\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class AuthRouteServiceProvider extends RouteServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Modules\Auth\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapAuthApiRoutes();
        $this->mapPermissionsApiRoutes();
    }

    protected function mapAuthApiRoutes()
    {
        Route::prefix('api/auth')
            ->middleware('api')
            ->namespace($this->namespace)
            ->name('api.auth.')
            ->group(base_path('modules/Auth/routes/auth/api.php'));
    }

    protected function mapPermissionsApiRoutes()
    {
        Route::prefix('api/')
            ->middleware('api')
            ->namespace($this->namespace)
            ->name('api.auth.')
            ->group(base_path('modules/Auth/routes/permissions/api.php'));
    }
}
