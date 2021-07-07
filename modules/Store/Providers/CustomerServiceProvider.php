<?php

namespace Modules\Store\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Modules\Store\Http\Controllers\CustomerController;
use Modules\Store\Models\Customer;
use Modules\Store\Services\CustomerService;
use Support\Interfaces\Services\IModelService;

class CustomerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerCustomerServiceDependencies();
        $this->registerCustomerConrtrollerDependencies();
    }

    public function registerCustomerConrtrollerDependencies()
    {
        $this->app->when(CustomerController::class)
                  ->needs(IModelService::class)
                  ->give(CustomerService::class);
    }

    public function registerCustomerServiceDependencies()
    {
        $this->app->when(CustomerService::class)
                  ->needs(Model::class)
                  ->give(Customer::class);
    }
}
