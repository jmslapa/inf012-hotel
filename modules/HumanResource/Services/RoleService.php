<?php

namespace Modules\HumanResource\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\HumanResource\Models\Role;
use Modules\HumanResource\Services\Payloads\RoleFilterPayload;
use Support\Abstracts\Services\EloquentModelService;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class RoleService extends EloquentModelService
{
    public function getFilters(): IEloquentFiltersPayload
    {
        return RoleFilterPayload::makeFromRequest(request());
    }

    public function all()
    {
        $resource = parent::all();
        $permissions = $this->getFilters()->getPermissions();
        if ($permissions !== null) {
            $isPaginator = $resource instanceof LengthAwarePaginator;
            $col = $isPaginator ? $resource->getCollection() : $resource;
            $col = $col->loadMissing('permissions')->filter(
                fn($e) => $e->permissions->pluck('id')->intersect($permissions)->count() === count($permissions)
            );
            $resource = $isPaginator ? $resource->setCollection($col) : $col;
        }
        return $resource;
    }

    public function create(array $data): object
    {
        $role = parent::create($data);

        if (isset($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        }

        return $role;
    }

    public function update(object $model, array $data): object
    {
        if (isset($data['permissions'])) {
            $model->permissions()->sync($data['permissions']);
        }

        return parent::update($model, $data);
    }

    public function delete(object $model): void
    {
        if ($model->employees()->count() > 0) {
            abort(400, 'Unable to delete. There are still employees registered in this role.');
        }

        $model->permissions()->sync([]);
        parent::delete($model);
    }
}
