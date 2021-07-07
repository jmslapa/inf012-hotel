<?php

namespace Modules\Company\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Company\Http\Requests\CompanyFormRequest;
use Modules\Company\Models\Company;
use Support\Interfaces\Services\IModelService;

class CompanyController extends Controller
{
    private $service;
    private $request;

    public function __construct(IModelService $service)
    {
        $this->service = $service;
        $this->request = app(CompanyFormRequest::class);
        $this->authorizeResource(Company::class, Company::class);
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
        return response()->json($this->service->create($this->request->all()), 201);
    }

    public function update(int $id)
    {
        return response()->json($this->service->find($id)->update($this->request->all()), 202);
    }

    public function destroy(int $id)
    {
        return response()->json($this->service->find($id)->delete($id), 204);
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
