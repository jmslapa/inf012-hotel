<?php

namespace Modules\Auth\Interfaces\Services;

use Modules\Auth\Interfaces\Services\Payloads\IBearerTokenPayload;

interface IAuthService
{
    /**
     * Realiza o login do usuário dono dos dados informados e retorna um bearer.
     *
     * @param string $email
     * @param string $password
     * @return IBearerTokenPayload
     */
    public function login(string $email, string $password): IBearerTokenPayload;

    /**
     * Retorna os dados do usuário atualmente atenticado.
     *
     * @return object
     */
    public function me(): object;

    /**
     * Realiza o logout do usuário e inativação do token atualmente ativo.
     *
     * @return void
     */
    public function logout(): void;
}
