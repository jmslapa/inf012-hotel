<?php

namespace App\Providers;

use ReflectionClass;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Support\Providers\SupportServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(SupportServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadModulesProviders();
    }

    private function loadModulesProviders()
    {
        $_ = DIRECTORY_SEPARATOR;
        $modules = File::directories(base_path('modules'));
        $files = collect($modules)->reduce(function ($files, $module) use ($_) {
            $dir = "{$module}{$_}Providers";
            if (File::isDirectory($dir)) {
                $files->push(File::allFiles($dir));
            }
            return $files;
        }, collect())
        ->collapse()
        ->filter(fn($f) => $f->getExtension() === 'php');

        $files->each(function ($f) {
            $className = Str::before(
                str_replace(
                    DIRECTORY_SEPARATOR,
                    '\\',
                    ucfirst(
                        str_replace(
                            Str::before($f->getPathName(), 'modules'),
                            '',
                            $f->getPathName()
                        )
                    )
                ),
                '.php'
            );
            if (class_exists($className) && (new ReflectionClass($className))->isSubclassOf(ServiceProvider::class)) {
                $this->app->register($className);
            }
        });
    }
}
