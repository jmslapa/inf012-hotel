<?php

namespace Modules\Auth\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Modules\Auth\Models\User;
use Modules\Auth\Services\UserService;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerUserServiceDependencies();
    }

    public function registerUserServiceDependencies()
    {
        $this->app->when(UserService::class)
                  ->needs(Model::class)
                  ->give(User::class);
    }
}
