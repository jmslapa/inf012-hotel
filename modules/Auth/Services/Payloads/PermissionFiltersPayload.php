<?php

namespace Modules\Auth\Services\Payloads;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class PermissionFiltersPayload implements IEloquentFiltersPayload
{
    private ?string $name;

    private function __construct(?string $name)
    {
        $this->name = $name;
    }

    public static function makeFromRequest(Request $request): IEloquentFiltersPayload
    {
        return new PermissionFiltersPayload(request('name'));
    }

    public function applyFilters(Builder $query): Builder
    {
        return $query->when($this->name !== null, fn($q) => $q->where('name', 'like', "%{$this->name}%"));
    }
}
