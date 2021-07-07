<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Http\Requests\PermissionFormRequest;
use Modules\Auth\Models\Permission;
use Support\Interfaces\Services\IModelService;

class PermissionController extends Controller
{
    private $request;
    private $service;

    public function __construct(IModelService $service)
    {
        $this->request = app(PermissionFormRequest::class);
        $this->service = $service;
        $this->authorizeResource(Permission::class, Permission::class);
    }

    public function index()
    {
        return response()->json($this->service->all(), 200);
    }
}
