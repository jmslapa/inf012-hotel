<?php

namespace Modules\Product\Interfaces\Products;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Common\Interfaces\Models\IImageable;

interface IRentable extends IProduct, IImageable
{
    /**
     * Relacionamento de Rentable com Images.
     *
     * @return Relation
     */
    public function images(): Relation;

    /**
     * Calcula o valor do arrendamento.
     *
     * @param Carbon $start Data de início do arrendamento.
     * @param Carbon $end Data de fim do arrendamento.
     * @return float
     */
    public function calcRentalValue(Carbon $start, Carbon $end): float;

    /**
     * Checa se o produto já está arrendado.
     *
     * @return boolean
     */
    public function isRented(): bool;
}
