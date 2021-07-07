<?php

namespace Support\Providers;

use ReflectionClass;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $_ = DIRECTORY_SEPARATOR;

        $files = collect(File::allFiles(base_path("support{$_}Providers")))
                 ->filter(fn($f) => $f->getExtension() === 'php');

        $files->each(function ($f) {
            $className = Str::before(
                str_replace(
                    DIRECTORY_SEPARATOR,
                    '\\',
                    ucfirst(
                        str_replace(
                            Str::before($f->getPathName(), 'support'),
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
