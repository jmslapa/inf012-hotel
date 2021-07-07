<?php

namespace Modules\Product\Policies;

use Modules\Product\Models\Categories\RentableCategory;
use Support\Abstracts\Policies\ModelPolicy;

class RentableCategoryPolicy extends ModelPolicy
{
    public function getTarget(): string
    {
        return RentableCategory::class;
    }
}
