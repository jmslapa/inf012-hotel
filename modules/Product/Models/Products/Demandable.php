<?php

namespace Modules\Product\Models\Products;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Product\Abstracts\Products\Product;
use Modules\Product\Interfaces\Products\IDemandable;
use Modules\Product\Models\Categories\DemandableCategory;

class Demandable extends Product implements IDemandable
{
    /**
     * @return BelongsToMany
     */
    public function categories(): Relation
    {
        return $this->belongsToMany(DemandableCategory::class, 'category_demandable', 'demandable_id', 'category_id');
    }

    public function calcTotalValue(float $amount): float
    {
        return bcmul($amount, $this->unit_price, 2);
    }
}
