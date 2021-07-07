<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\Enums\PolicyMethod;
use Modules\Product\Http\Requests\RentableFormRequest;
use Modules\Product\Interfaces\Services\IRentableService;
use Modules\Product\Models\Products\Rentable;

class RentableController extends Controller
{
    private FormRequest $request;
    private $service;

    public function __construct(IRentableService $service)
    {
        $this->service = $service;
        $this->request = app(RentableFormRequest::class);
        $this->authorizeResource(Rentable::class, Rentable::class);
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

    public function uploadImages(int $id)
    {
        $this->authorize(PolicyMethod::UPDATE, Rentable::class);
        return response()->json(
            $this->service->uploadImages(
                $this->service->find($id),
                $this->request->images
            ),
            202
        );
    }

    public function removeImages(int $id)
    {
        $this->authorize(PolicyMethod::UPDATE, Rentable::class);
        return response()->json(
            $this->service->removeImages(
                $this->service->find($id),
                $this->request->images
            ),
            200
        );
    }
}
