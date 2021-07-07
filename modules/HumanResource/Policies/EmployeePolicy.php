<?php

namespace Modules\HumanResource\Policies;

use Modules\HumanResource\Models\Employee;
use Support\Abstracts\Policies\ModelPolicy;

class EmployeePolicy extends ModelPolicy
{
    public function getTarget(): string
    {
        return Employee::class;
    }
}
