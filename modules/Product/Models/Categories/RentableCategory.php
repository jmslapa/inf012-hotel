<?php

namespace Modules\Product\Models\Categories;

use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Product\Abstracts\Categories\ProductCategory;
use Modules\Product\Models\Products\Rentable;

class RentableCategory extends ProductCategory
{
    protected $table = 'rentable_categories';

    protected $hidden = [
        'deleted_at',
        'pivot'
    ];

    public function products(): Relation
    {
        return $this->belongsToMany(Rentable::class, 'category_rentable', 'category_id');
    }
}
