<?php

namespace Modules\HumanResource\Providers;

use Modules\HumanResource\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Support\Interfaces\Services\IModelService;
use Modules\HumanResource\Services\RoleService;
use Modules\HumanResource\Http\Controllers\RoleController;

class RoleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerRoleControllerDependencies();
        $this->registerRoleServiceDependencies();
    }

    public function registerRoleControllerDependencies()
    {
        $this->app->when(RoleController::class)
                  ->needs(IModelService::class)
                  ->give(RoleService::class);
    }

    public function registerRoleServiceDependencies()
    {
        $this->app->when(RoleService::class)
                  ->needs(Model::class)
                  ->give(Role::class);
    }
}
