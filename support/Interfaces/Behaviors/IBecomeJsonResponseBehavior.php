<?php

namespace Support\Interfaces\Behaviors;

interface IBecomeJsonResponseBehavior
{
    /**
     * Realiza o coportamento de se tornar uma responsta json.
     *
     * @param array $data Array associativo com dados a serem encodificados no formato json.
     * @param integer $status Código de status HTTP da resposta.
     * @param array $headers Cabeçalhos da resposta.
     * @return void
     */
    public function perform(array $data = [], int $status = 200, array $headers = []): object;
}
