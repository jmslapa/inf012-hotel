<?php

namespace Modules\Company\Services\Payloads;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class CompanyFilterPayload implements IEloquentFiltersPayload
{
    public static function makeFromRequest(Request $request): IEloquentFiltersPayload
    {
        return new CompanyFilterPayload();
    }

    public function applyFilters(Builder $query): Builder
    {
        return $query;
    }
}