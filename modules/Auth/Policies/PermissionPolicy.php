<?php

namespace Modules\Auth\Policies;

use Modules\Auth\Models\Permission;
use Support\Abstracts\Policies\ModelPolicy;

class PermissionPolicy extends ModelPolicy
{
    public function getTarget(): string
    {
        return Permission::class;
    }
}
