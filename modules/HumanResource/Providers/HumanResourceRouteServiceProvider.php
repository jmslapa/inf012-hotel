<?php

namespace Modules\HumanResource\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class HumanResourceRouteServiceProvider extends RouteServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Modules\HumanResource\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapRoleApiRoutes();
        $this->mapEmployeeApiRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapRoleApiRoutes()
    {
        Route::prefix('api/hr')
            ->middleware('api')
            ->namespace($this->namespace)
            ->name('api.hr.')
            ->group(base_path('modules/HumanResource/routes/role/api.php'));
    }

    protected function mapEmployeeApiRoutes()
    {
        Route::prefix('api/hr')
            ->middleware('api')
            ->namespace($this->namespace)
            ->name('api.hr.')
            ->group(base_path('modules/HumanResource/routes/employee/api.php'));
    }
}
