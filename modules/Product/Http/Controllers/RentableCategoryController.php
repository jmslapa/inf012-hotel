<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Product\Http\Requests\ProductCategoryFormRequest;
use Modules\Product\Models\Categories\RentableCategory;
use Support\Interfaces\Services\IModelService;

class RentableCategoryController extends Controller
{
    private FormRequest $request;
    private IModelService $service;

    public function __construct(IModelService $service)
    {
        $this->service = $service;
        $this->request = app(ProductCategoryFormRequest::class);
        $this->authorizeResource(RentableCategory::class, RentableCategory::class);
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
        return response()->json(
            $this->service->create(
                $this->request->validated()
            ),
            201
        );
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
