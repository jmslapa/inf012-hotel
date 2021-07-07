<?php

namespace Modules\Company\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Modules\Company\Http\Controllers\CompanyController;
use Modules\Company\Models\Company;
use Modules\Company\Services\CompanyService;
use Support\Interfaces\Services\IModelService;

class CompanyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerCompanyControllerDependencies();
        $this->registerCompanyServiceDependencies();
    }

    public function registerCompanyControllerDependencies()
    {
        $this->app->when(CompanyController::class)
                  ->needs(IModelService::class)
                  ->give(CompanyService::class);
    }

    public function registerCompanyServiceDependencies()
    {
        $this->app->when(CompanyService::class)
                  ->needs(Model::class)
                  ->give(Company::class);
    }
}
