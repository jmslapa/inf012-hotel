<?php

namespace Modules\HumanResource\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\HumanResource\Http\Requests\RoleFormRequest;
use Modules\HumanResource\Models\Role;
use Support\Interfaces\Services\IModelService;

class RoleController extends Controller
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var IModelService
     */
    private $service;

    public function __construct(IModelService $service)
    {
        $this->request = app(RoleFormRequest::class);
        $this->service = $service;
        $this->authorizeResource(Role::class, Role::class);
    }

    public function index()
    {
        $resource = $this->service->all();
        return response()->json($resource, 200);
    }

    public function show(int $id)
    {
        $resource = $this->service->find($id);
        return response()->json($resource, 200);
    }

    public function store()
    {
        $resource = $this->service->create($this->request->validated());
        return response()->json($resource, 201);
    }

    public function update(int $id)
    {
        $resource = $this->service->update($this->service->find($id), $this->request->validated());
        return response()->json($resource, 202);
    }

    public function destroy(int $id)
    {
        $resource = $this->service->delete($this->service->find($id));
        return response()->json($resource, 204);
    }
}
