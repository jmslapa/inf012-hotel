<?php

namespace Modules\HumanResource\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\HumanResource\Services\Payloads\EmployeeFilterPayload;
use Support\Abstracts\Services\EloquentModelService;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class EmployeeService extends EloquentModelService
{
    private $filters;

    /**
     * @return EmployeeFilterPayload
     */
    public function getFilters(): IEloquentFiltersPayload
    {
        if ($this->filters === null) {
            $this->filters = EmployeeFilterPayload::makeFromRequest(request());
        }
        return $this->filters;
    }

    public function all()
    {
        $resource = parent::all();
        $permissions = $this->getFilters()->getPermissions();
        if ($permissions !== null) {
            $isPaginator = $resource instanceof LengthAwarePaginator;
            $col = $isPaginator ? $resource->getCollection() : $resource;
            $col = $col->filter(
                fn($e) => $e->role
                    ->loadMissing('permissions')
                    ->pluck('id')
                    ->intersect($permissions)
                    ->count() === count($permissions)
            );
            $resource = $isPaginator ? $resource->setCollection($col) : $col;
        }
        return $resource;
    }

    public function create(array $data): object
    {
        $employee = parent::create($data);
        $employee->user()->create(collect($data)->only($employee->user()->getModel()->getFillable())->all());
        return $employee;
    }

    public function update(object $model, array $data): object
    {
        $employee = parent::update($model, $data);
        return $employee;
    }

    public function delete(object $model): void
    {
        $model->user()->delete();
        parent::delete($model);
    }
}
