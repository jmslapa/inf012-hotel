<?php

namespace Modules\Auth\Interfaces\Services;

interface IPermissionService
{
    /**
     * Realiza inserção em massa;
     *
     * @param array $data Array de arrays associativos com dados a serem persistidos.
     * @return bool
     */
    public function createMany(array $data): bool;
}
