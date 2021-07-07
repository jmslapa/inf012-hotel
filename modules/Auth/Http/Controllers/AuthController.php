<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Http\Requests\AuthFormRequest;
use Modules\Auth\Interfaces\Services\IAuthService;

class AuthController extends Controller
{
    private $request;
    private $service;

    public function __construct(IAuthService $service)
    {
        $this->request = app(AuthFormRequest::class);
        $this->service = $service;
    }

    public function login()
    {
        ['email' => $email, 'password' => $password] = $this->request->validated();
        return $this->service->login($email, $password)->toJsonResponse(202);
    }

    public function me()
    {
        return response()->json($this->service->me(), 200);
    }

    public function logout()
    {
        return response()->json($this->service->logout(), 204);
    }
}
