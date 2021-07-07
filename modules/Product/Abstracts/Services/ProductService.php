<?php

namespace Modules\Product\Abstracts\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\Product\Interfaces\Products\IProduct;
use Modules\Product\Services\Payloads\ProductFiltersPayload;
use Support\Abstracts\Services\EloquentModelService;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

abstract class ProductService extends EloquentModelService
{
    private $filters;

    /**
     * @return IProductFiltersPayload
     */
    public function getFilters(): IEloquentFiltersPayload
    {
        if (!($this->filters instanceof IProductFiltersPayload)) {
            $this->filters = ProductFiltersPayload::makeFromRequest(request());
        }
        return $this->filters;
    }

    public function all()
    {
        $this->filters;
        $resource = parent::all();
        $categories = $this->getFilters()->getCategories();
        if ($categories !== null) {
            $resource = manipulateEloquentCollectionOrPaginator(
                $resource,
                function (Collection $col) use ($categories) {
                    return $col->loadMissing('categories')->filter(function ($rentable) use ($categories) {
                        $rentableCategories = $rentable->categories->pluck('id')->intersect($categories);
                        return $rentableCategories->count()  === count($categories);
                    });
                }
            );
        }
        return $resource;
    }

    /**
     * @return IProduct
     */
    public function create(array $data): object
    {
        $rentable = parent::create($data);
        $rentable->categories()->sync($data['categories']);
        return $rentable->load('categories');
    }

    /**
     * @param IProduct $model
     * @return IProduct
     */
    public function update(object $model, array $data): object
    {
        $model->categories()->sync($data['categories']);
        $rentable = parent::update($model, $data);
        return $rentable->load('categories');
    }

    /**
     * @param IProduct $model
     */
    public function delete(object $model): void
    {
        $model->categories()->sync([]);
        parent::delete($model);
    }
}
