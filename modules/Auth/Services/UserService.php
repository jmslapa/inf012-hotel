<?php

namespace Modules\Auth\Services;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Interfaces\Services\IUserService;
use Modules\Auth\Models\User;
use Modules\Auth\Services\Payloads\UserFiltersPayload;
use Support\Abstracts\Services\EloquentModelService;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService extends EloquentModelService implements IUserService
{
    public function getFilters(): IEloquentFiltersPayload
    {
        return UserFiltersPayload::makeFromRequest(request());
    }

    /**
     * @return User
     */
    public function findByEmail(string $email): object
    {
        $user = $this->newQuery()->where('email', $email)->first();
        if (!$user) {
            abort(404, 'Resource not found.');
        }
        return $user;
    }
}
