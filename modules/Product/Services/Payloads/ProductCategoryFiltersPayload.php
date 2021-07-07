<?php

namespace Modules\Product\Services\Payloads;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class ProductCategoryFiltersPayload implements IEloquentFiltersPayload
{
    private $name;

    private function __construct(?string $name)
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return ProductCategoryFiltersPayload
     */
    public static function makeFromRequest(Request $request): IEloquentFiltersPayload
    {
        return new ProductCategoryFiltersPayload(request('name'));
    }

    public function applyFilters(Builder $query): Builder
    {
        return $query->when($this->name !== null, fn(Builder $q) => $q->where('name', 'like', "%{$this->name}%"));
    }
}
