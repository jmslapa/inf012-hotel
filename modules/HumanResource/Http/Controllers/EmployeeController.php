<?php

namespace Modules\HumanResource\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Auth\Enums\PolicyMethod;
use Modules\HumanResource\Http\Requests\EmployeeFormRequest;
use Modules\HumanResource\Models\Employee;
use Support\Interfaces\Services\IModelService;

class EmployeeController extends Controller
{
    private $request;
    private $service;

    public function __construct(IModelService $service)
    {
        $this->request = app(EmployeeFormRequest::class);
        $this->service = $service;
        $this->authorizeResource(Employee::class, Employee::class);
    }

    public function index()
    {
        return response()->json($this->service->all(), 200);
    }

    public function show(int $id)
    {
        return response()->json($this->service->find($id), 200);
    }

    public function store()
    {
        return response()->json($this->service->create($this->request->validated()), 201);
    }

    public function update(int $id)
    {
        return response()->json($this->service->update($this->service->find($id), $this->request->validated()), 202);
    }

    public function destroy(int $id)
    {
        return response()->json($this->service->delete($this->service->find($id)), 204);
    }
}
