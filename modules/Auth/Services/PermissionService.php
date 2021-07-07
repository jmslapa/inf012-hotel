<?php

namespace Modules\Auth\Services;

use Illuminate\Support\Facades\DB;
use Modules\Auth\Interfaces\Services\IPermissionService;
use Modules\Auth\Services\Payloads\PermissionFiltersPayload;
use Support\Abstracts\Services\EloquentModelService;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class PermissionService extends EloquentModelService implements IPermissionService
{
    public function getFilters(): IEloquentFiltersPayload
    {
        return PermissionFiltersPayload::makeFromRequest(request());
    }
    
    public function createMany(array $data): bool
    {
        return DB::transaction(function () use ($data) {
            return $this->newQuery()->insert($data);
        });
    }

    public function delete(object $model): void
    {
        $model->roles()->sync([]);
        parent::delete($model);
    }
}
