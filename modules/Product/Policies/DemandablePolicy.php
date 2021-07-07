<?php

namespace Modules\Product\Policies;

use Modules\Product\Models\Products\Demandable;
use Support\Abstracts\Policies\ModelPolicy;

class DemandablePolicy extends ModelPolicy
{
    public function getTarget(): string
    {
        return Demandable::class;
    }
}
