<?php

namespace Modules\Company\Policies;

use Modules\Company\Models\Company;
use Support\Abstracts\Policies\ModelPolicy;

class CompanyPolicy extends ModelPolicy
{
    public function getTarget(): string
    {
        return Company::class;
    }
}
