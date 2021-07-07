<?php

namespace Modules\Common\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Common\Rules\ImageExists;

class ImageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerValidationRules();
    }

    public function registerValidationRules()
    {
        $this->app->singleton('image_exists', fn() => new ImageExists());
    }
}
