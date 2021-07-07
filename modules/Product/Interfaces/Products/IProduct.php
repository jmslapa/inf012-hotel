<?php

namespace Modules\Product\Interfaces\Products;

use Illuminate\Database\Eloquent\Relations\Relation;

interface IProduct
{
    /**
     * Relacionamento entre categoria e produto.
     *
     * @return Relation
     */
    public function categories(): Relation;
}
