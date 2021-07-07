<?php

namespace Support\Providers;

use Illuminate\Support\ServiceProvider;
use Support\Behaviors\BecomeAIlluminateJsonResponseBehavior;
use Support\Interfaces\Behaviors\IBecomeJsonResponseBehavior;

class BehaviorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(IBecomeJsonResponseBehavior::class, BecomeAIlluminateJsonResponseBehavior::class);
    }
}
