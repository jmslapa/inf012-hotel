<?php

namespace Modules\Product\Services\Payloads;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Modules\Product\Interfaces\Services\Payloads\IProductFiltersPayload;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class ProductFiltersPayload implements IProductFiltersPayload
{
    private $title;
    private $minUnitPrice;
    private $maxUnitPrice;
    private $categories;

    private function __construct(
        ?string $title,
        ?float $minUnitPrice,
        ?float $maxUnitPrice,
        ?array $categories
    ) {
        $this->title = $title;
        $this->minUnitPrice = $minUnitPrice;
        $this->maxUnitPrice = $maxUnitPrice;
        $this->categories = $categories;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getMinUnitPrice(): ?float
    {
        return $this->minUnitPrice;
    }

    public function getMaxUnitPrice(): ?float
    {
        return $this->maxUnitPrice;
    }

    public function getCategories(): ?array
    {
        return $this->categories;
    }

    /**
     * @return IProductFiltersPayload
     */
    public static function makeFromRequest(Request $request): IEloquentFiltersPayload
    {
        return new ProductFiltersPayload(
            request()->query('title'),
            request()->query('min_unit_price'),
            request()->query('max_unit_price'),
            request()->query('categories') ? explode(',', trim(request()->query('categories'), ", \t\n\r\0\x0B")) : null
        );
    }

    public function applyFilters(Builder $query): Builder
    {
        return $query
            ->when($this->title !== null, fn(Builder $q) => $q->where('title', 'like', "%{$this->title}%"))
            ->when($this->minUnitPrice !== null, fn(Builder $q) => $q->where('unit_price', '>=', $this->minUnitPrice))
            ->when($this->maxUnitPrice !== null, fn(Builder $q) => $q->where('unit_price', '<=', $this->maxUnitPrice))
            ->when($this->categories !== null, function (Builder $q) {
                return $q->whereHas('categories', fn(Builder $sq) => $sq->whereIn('id', $this->categories));
            });
    }
}
