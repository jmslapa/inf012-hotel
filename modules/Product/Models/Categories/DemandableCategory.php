<?php

namespace Modules\Product\Models\Categories;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Product\Abstracts\Categories\ProductCategory;
use Modules\Product\Models\Products\Demandable;

class DemandableCategory extends ProductCategory
{
    protected $hidden = [
        'deleted_at',
        'pivot'
    ];

    /**
     * @return BelongsToMany
     */
    public function products(): Relation
    {
        $this->belongsToMany(Demandable::class, 'category_id');
    }
}
