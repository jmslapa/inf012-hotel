<?php

namespace Modules\Store\Enums;

use Support\Abstracts\Enums\Enum;

class Status extends Enum
{
    public const PENDING = 'PENDING';
    public const FINISHED = 'FINISHED';
    public const CANCELLED = 'CANCELLED';
}
