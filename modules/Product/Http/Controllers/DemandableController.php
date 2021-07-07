<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Product\Http\Requests\DemandableFormRequest;
use Modules\Product\Models\Products\Demandable;
use Support\Interfaces\Services\IModelService;

class DemandableController extends Controller
{
    private FormRequest $request;
    private $service;

    public function __construct(IModelService $service)
    {
        $this->service = $service;
        $this->request = app(DemandableFormRequest::class);
        $this->authorizeResource(Demandable::class, Demandable::class);
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
        return response()->json(
            $this->service->update(
                $this->service->find($id),
                $this->request->validated()
            ),
            202
        );
    }

    public function destroy(int $id)
    {
        return response()->json(
            $this->service->delete(
                $this->service->find($id)
            ),
            204
        );
    }
}
