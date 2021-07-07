<?php

namespace Modules\HumanResource\Policies;

use Modules\HumanResource\Models\Role;
use Support\Abstracts\Policies\ModelPolicy;

class RolePolicy extends ModelPolicy
{
    public function getTarget(): string
    {
        return Role::class;
    }
}
