<?php

namespace Modules\Auth\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Auth\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Modules\Auth\Services\UserService;
use Modules\Auth\Services\SanctumAuthService;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Interfaces\Services\IAuthService;
use Modules\Auth\Interfaces\Services\IUserService;
use Modules\Auth\Services\Payloads\SanctumTokenPayload;
use Modules\Auth\Interfaces\Services\Payloads\IBearerTokenPayload;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Support\Abstracts\Policies\ModelPolicy;

class AuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerSanctumAuthServiceDependencies();
        $this->registerAuthControllerDepedencies();
        $this->performBindings();
    }

    public function boot()
    {
        $this->defineAbilities();
        $this->registerPolicies();
    }

    public function registerPolicies()
    {
        $this->searchPolicies();
        parent::registerPolicies();
    }

    public function performBindings()
    {
        $this->app->bind(IBearerTokenPayload::class, SanctumTokenPayload::class);
    }

    public function registerAuthControllerDepedencies()
    {
        $this->app->when(AuthController::class)
                  ->needs(IAuthService::class)
                  ->give(SanctumAuthService::class);
    }

    public function registerSanctumAuthServiceDependencies()
    {
        $this->app->when(SanctumAuthService::class)
                  ->needs(IUserService::class)
                  ->give(UserService::class);
    }

    public function defineAbilities()
    {
        Gate::before(function (User $user) {
            if ($user->isAdministrator) {
                return true;
            }
        });
    }

    public function searchPolicies()
    {
        $modules = collect(File::directories(base_path('modules')));
        $modules = $modules->map(function ($m) {
            $modelsDirectory = "{$m}/Models";
            $policiesDirectory = "{$m}/Policies";
            if (!is_dir($modelsDirectory) || !is_dir($policiesDirectory)) {
                return [];
            }
            return collect(File::allFiles($modelsDirectory))->reduce(function ($acc, $f) use ($policiesDirectory) {
                if ($f->getExtension() !== 'php') {
                    return false;
                }
                $relativePath = str_replace('.php', '', Str::after($f->getPathName(), base_path()));
                $namespace = str_replace(DIRECTORY_SEPARATOR, '\\', ucfirst(trim($relativePath, DIRECTORY_SEPARATOR)));
                if (class_exists($namespace) && is_subclass_of($namespace, Model::class)) {
                    $policy = collect(File::allFiles($policiesDirectory))->reduce(function ($p, $f) use ($namespace) {
                        if ($f->getExtension() === 'php') {
                            $relativePath = str_replace('.php', '', Str::after($f->getPathName(), base_path()));
                            $pNamespace = str_replace(
                                DIRECTORY_SEPARATOR,
                                '\\',
                                ucfirst(trim($relativePath, DIRECTORY_SEPARATOR))
                            );
                            $modelName = collect(explode('\\', $namespace))->last();
                            if (Str::endsWith($pNamespace, "{$modelName}Policy") && class_exists($pNamespace)) {
                                $p = $pNamespace;
                            }
                            return $p;
                        }
                    }, null);
                    if ($policy !== null) {
                        $acc[$namespace] = $policy;
                    }
                }
                return $acc;
            }, []);
        });

        $this->policies = $modules->collapse()->all();
    }
}
