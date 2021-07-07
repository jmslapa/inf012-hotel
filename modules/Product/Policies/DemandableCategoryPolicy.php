<?php

namespace Modules\Product\Policies;

use Modules\Product\Models\Categories\DemandableCategory;
use Support\Abstracts\Policies\ModelPolicy;

class DemandableCategoryPolicy extends ModelPolicy
{
    public function getTarget(): string
    {
        return DemandableCategory::class;
    }
}
