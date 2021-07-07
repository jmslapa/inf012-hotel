<?php

namespace Modules\Product\Interfaces\Categories;

use Illuminate\Database\Eloquent\Relations\Relation;

interface IProductCategory
{
    /**
     * Relacionamento entre categoria e produto.
     *
     * @return Relation
     */
    public function products(): Relation;
}
