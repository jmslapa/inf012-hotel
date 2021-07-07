<?php

namespace Modules\Store\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Enums\PolicyMethod;
use Modules\Store\Http\Requests\CustomerFormRequest;
use Modules\Store\Models\Customer;
use Support\Interfaces\Services\IModelService;

class CustomerController extends Controller
{
    private $request;
    private $service;

    public function __construct(IModelService $service)
    {
        $this->service = $service;
        $this->request = app(CustomerFormRequest::class);
    }

    public function index()
    {
        $this->authorize(PolicyMethod::VIEW_ANY, Customer::class);
        return response()->json($this->service->all(), 200);
    }

    public function show(int $id)
    {
        $customer = $this->service->find($id);
        $this->authorize(PolicyMethod::VIEW, $customer);
        return response()->json($customer, 200);
    }

    public function store()
    {
        $this->authorize(PolicyMethod::CREATE, Customer::class);
        return response()->json($this->service->create($this->request->validated()), 201);
    }

    public function update(int $id)
    {
        $customer = $this->service->find($id);
        $this->authorize(PolicyMethod::UPDATE, $customer);
        return response()->json(
            $this->service->update(
                $customer,
                $this->request->validated()
            ),
            202
        );
    }

    public function destroy(int $id)
    {
        $this->authorize(PolicyMethod::DELETE, Customer::class);
        return response()->json(
            $this->service->delete(
                $this->service->find($id)
            ),
            204
        );
    }

    public function addPhone(int $customer)
    {
        $customer = $this->service->find($customer);
        $this->authorize(PolicyMethod::UPDATE, $customer);
        return response()->json(
            $this->service->addPhone(
                $customer,
                $this->request->number
            ),
            202
        );
    }

    public function removePhone(int $customer, int $phone)
    {
        $customer = $this->service->find($customer);
        $this->authorize(PolicyMethod::UPDATE, $customer);
        return response()->json(
            $this->service->removePhone(
                $customer,
                $phone
            ),
            204
        );
    }
}
