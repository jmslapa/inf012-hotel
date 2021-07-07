<?php

namespace Modules\Auth\Services\Payloads;

use Laravel\Sanctum\NewAccessToken;
use Modules\Auth\Interfaces\Services\Payloads\IBearerTokenPayload;
use Support\Interfaces\Behaviors\IBecomeJsonResponseBehavior;

class SanctumTokenPayload implements IBearerTokenPayload
{
    private const TOKEN_TYPE = 'Bearer';
    private $token;

    public function __construct(NewAccessToken $token)
    {
        $this->token = $token;
    }

    public function getBearer(): string
    {
        return $this->token->plainTextToken;
    }

    public function toJsonResponse(int $status = 200, array $headers = [])
    {
        return app(IBecomeJsonResponseBehavior::class)->perform([
            'token' => $this->getBearer(),
            'token_type' => self::TOKEN_TYPE
        ], $status, $headers);
    }
}
