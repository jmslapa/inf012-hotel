<?php

namespace Modules\Auth\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Auth\Interfaces\Services\IAuthService;
use Modules\Auth\Interfaces\Services\IUserService;
use Modules\Auth\Interfaces\Services\Payloads\IBearerTokenPayload;
use Modules\Auth\Models\User;
use Modules\Auth\Services\Payloads\SanctumTokenPayload;

class SanctumAuthService implements IAuthService
{
    private $userService;

    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return SanctumTokenPayload
     */
    public function login(string $email, string $password): IBearerTokenPayload
    {
        if (!Auth::guard('web')->attempt(['email' => $email, 'password' => $password])) {
            abort(401, 'Confira se os dados de acesso estão corretos.');
        }

        $user = $this->userService->findByEmail($email);
        $user->tokens()->delete();
        return app(IBearerTokenPayload::class, ['token' => $user->createToken('auth_token')]);
    }

    /**
     * @return User
     */
    public function me(): object
    {
        return auth()->user()->authenticatable;
    }

    public function logout(): void
    {
        auth()->user()->currentAccessToken()->delete();
    }
}
