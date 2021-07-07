<?php

namespace Modules\HumanResource\Services\Payloads;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Modules\Auth\Services\Payloads\UserFiltersPayload;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class EmployeeFilterPayload extends UserFiltersPayload
{
    private $name;
    private $cpf;
    private $gender;
    private $enabled;
    private $role_id;
    private $permissions;

    private function __construct(
        ?string $email,
        ?string $name,
        ?string $cpf,
        ?string $gender,
        ?bool $enabled,
        ?int $role_id,
        ?array $permissions
    ) {
        parent::__construct($email);
        $this->name = $name;
        $this->cpf = $cpf;
        $this->gender = $gender;
        $this->enabled = $enabled;
        $this->role_id = $role_id;
        $this->permissions = $permissions;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
    public function getCpf(): ?string
    {
        return $this->cpf;
    }
    public function getGender(): ?string
    {
        return $this->gender;
    }
    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function getRoleId(): ?int
    {
        return $this->role_id;
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

        return new EmployeeFilterPayload(
            request()->query('email'),
            request()->query('name'),
            request()->query('cpf'),
            request()->query('gender'),
            request()->query('enabled'),
            request()->query('role_id'),
            $permissions
        );
    }

    public function applyFilters(Builder $query): Builder
    {
        return $query
            ->when($this->name !== null, fn ($q) => $q->where('name', 'like', "%{$this->name}%"))
            ->when($this->cpf !== null, fn ($q) => $q->where('cpf', $this->cpf))
            ->when($this->gender !== null, fn ($q) => $q->where('gender', $this->gender))
            ->when($this->enabled !== null, fn ($q) => $q->where('enabled', $this->enabled))
            ->when($this->role_id !== null, fn ($q) => $q->where('role_id', $this->role_id))
            ->when($this->email !== null, function ($q) {
                return $q->whereHas('user', fn ($subQ) => parent::applyFilters($subQ));
            })
            ->when($this->permissions !== null, function ($query) {
                return $query->whereHas('role.permissions', fn($q) => $q->whereIn('id', $this->permissions));
            });
    }
}
