<?php

namespace Modules\Auth\Services\Payloads;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class UserFiltersPayload implements IEloquentFiltersPayload
{
    protected $email;

    protected function __construct(?string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public static function makeFromRequest(Request $request): IEloquentFiltersPayload
    {
        return new UserFiltersPayload(request('email'));
    }

    public function applyFilters(Builder $query): Builder
    {
        return $query->when($this->email !== null, fn(Builder $q) => $q->where('email', 'like', "%{$this->email}%"));
    }
}
