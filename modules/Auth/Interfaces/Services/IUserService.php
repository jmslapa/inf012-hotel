<?php

namespace Modules\Auth\Interfaces\Services;

use Support\Interfaces\Services\IEloquentModelService;
use Support\Interfaces\Services\IModelService;

interface IUserService extends IModelService, IEloquentModelService
{
    /**
     * Busca um usuário pelo e-mail cadastrado.
     *
     * @param string $email
     * @return object
     * @throws NotFoundHttpException
     */
    public function findByEmail(string $email): object;
}
