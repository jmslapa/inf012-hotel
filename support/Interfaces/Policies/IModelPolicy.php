<?php

namespace Support\Interfaces\Policies;

interface IModelPolicy
{
    /**
     * Retorna o target das permissões vinculadas à policy.
     *
     * @return string
     */
    public function getTarget(): string;
}
