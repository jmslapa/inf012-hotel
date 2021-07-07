<?php

namespace Modules\Product\Policies;

use Modules\Auth\Enums\PolicyMethod;
use Modules\Auth\Models\User;
use Modules\Product\Models\Products\Rentable;
use Support\Abstracts\Policies\ModelPolicy;

class RentablePolicy extends ModelPolicy
{
    public function getTarget(): string
    {
        return Rentable::class;
    }

    public function uploadImages(User $user)
    {
        $this->checkPermission($user, PolicyMethod::UPDATE);
    }

    public function removeImages(User $user)
    {
        $this->checkPermission($user, PolicyMethod::UPDATE);
    }
}
