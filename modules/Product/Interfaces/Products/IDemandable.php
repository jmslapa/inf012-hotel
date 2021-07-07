<?php

namespace Modules\Product\Interfaces\Products;

interface IDemandable extends IProduct
{
    /**
     * Calcula o valor baseado na quantidade
     *
     * @param float $amount Quantidade demandada
     * @return float
     */
    public function calcTotalValue(float $amount): float;
}
