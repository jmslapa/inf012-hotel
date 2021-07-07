<?php

namespace Modules\Auth\Interfaces\Services\Payloads;

interface IBearerTokenPayload
{
    public function getBearer(): string;
    public function toJsonResponse(int $status = 200, array $headers = []);
}
