<?php

namespace Modules\HumanResource\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Modules\HumanResource\Http\Controllers\EmployeeController;
use Modules\HumanResource\Models\Employee;
use Modules\HumanResource\Services\EmployeeService;
use Support\Interfaces\Services\IModelService;

class EmployeeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerEmployeeServiceDependencies();
        $this->registerEmployeeControllerDependencies();
    }

    public function registerEmployeeControllerDependencies()
    {
        $this->app->when(EmployeeController::class)
                  ->needs(IModelService::class)
                  ->give(EmployeeService::class);
    }

    public function registerEmployeeServiceDependencies()
    {
        $this->app->when(EmployeeService::class)
                  ->needs(Model::class)
                  ->give(Employee::class);
    }
}
