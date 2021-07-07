<?php

namespace Modules\Auth\Enums;

use Support\Abstracts\Enums\Enum;

class PolicyMethod extends Enum
{
    public const VIEW_ANY = 'viewAny';
    public const VIEW = 'view';
    public const CREATE = 'create';
    public const UPDATE = 'update';
    public const DELETE = 'delete';
}
