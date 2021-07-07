<?php

namespace Modules\Product\Interfaces\Services\Payloads;

use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

interface IProductFiltersPayload extends IEloquentFiltersPayload
{
    /**
     * Retorna o valor do filtro título.
     *
     * @return string|null
     */
    public function getTitle(): ?string;
    
    /**
     * Retorna o valor do filtro preço unitário mínimo.
     *
     * @return float|null
     */
    public function getMinUnitPrice(): ?float;
    
    /**
     * Retorna o valor do filtro preço unitáio máximo.
     *
     * @return float|null
     */
    public function getMaxUnitPrice(): ?float;
    
    /**
     * Retorna o valor do filtro categorias.
     *
     * @return array|null
     */
    public function getCategories(): ?array;
}
