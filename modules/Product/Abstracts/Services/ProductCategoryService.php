<?php

namespace Modules\Product\Abstracts\Services;

use Modules\Product\Interfaces\Categories\IProductCategory;
use Modules\Product\Services\Payloads\ProductCategoryFiltersPayload;
use Support\Abstracts\Services\EloquentModelService;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

abstract class ProductCategoryService extends EloquentModelService
{
    private $filters;

    public function getFilters(): IEloquentFiltersPayload
    {
        if (!$this->filters instanceof IEloquentFiltersPayload) {
            $this->filters = ProductCategoryFiltersPayload::makeFromRequest(request());
        }
        return $this->filters;
    }

    /**
     * @param IProductCategory $model
     */
    public function delete(object $model): void
    {
        if ($model->products()->count() > 0) {
            abort(400, 'Unable to delete. There are still products registered in this category.');
        }
        parent::delete($model);
    }
}
