<?php

namespace Modules\Auth\Providers;

use Modules\Auth\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Modules\Auth\Services\PermissionService;
use Support\Interfaces\Services\IModelService;
use Modules\Auth\Http\Controllers\PermissionController;
use Modules\Auth\Interfaces\Services\IPermissionService;

class PermissionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerPermissionServiceDependencies();
        $this->registerPermissionControllerDependencies();
        $this->performBindings();
    }

    public function registerPermissionServiceDependencies()
    {
        $this->app->when(PermissionService::class)
                  ->needs(Model::class)
                  ->give(Permission::class);
    }

    public function registerPermissionControllerDependencies()
    {
        $this->app->when(PermissionController::class)
                  ->needs(IModelService::class)
                  ->give(PermissionService::class);
    }

    public function performBindings()
    {
        $this->app->bind(IPermissionService::class, PermissionService::class);
    }
}
