<?php

namespace Modules\HumanResource\Services\Payloads;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class RoleFilterPayload implements IEloquentFiltersPayload
{
    private $name;
    private $enabled;
    private $permissions;

    private function __construct(?string $name, ?bool $enabled, ?array $permissions)
    {
        $this->name = $name;
        $this->enabled = $enabled;
        $this->permissions = $permissions;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function getPermissions(): ?array
    {
        return $this->permissions;
    }

    public static function makeFromRequest(Request $request): IEloquentFiltersPayload
    {
        $permissions = request()->query('permissions')
            ? explode(',', trim(request()->query('permissions'), ",\t\n\r\0\x0B"))
            : null;

        return new RoleFilterPayload(
            request()->query('name'),
            request()->query('enabled'),
            $permissions
        );
    }

    public function applyFilters(Builder $query): Builder
    {
        return $query
               ->when($this->name !== null, fn($q) => $q->where('name', 'like', "%{$this->name}%"))
               ->when($this->enabled !== null, fn($q) => $q->where('enabled', $this->enabled))
               ->when($this->permissions !== null, function (Builder $query) {
                   return $query->whereHas('permissions', fn($q) => $q->whereIn('id', $this->permissions));
               });
    }
}
