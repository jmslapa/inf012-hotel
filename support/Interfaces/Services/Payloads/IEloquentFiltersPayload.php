<?php

namespace Support\Interfaces\Services\Payloads;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

interface IEloquentFiltersPayload
{
    /**
     * Constrói um objeto do tiop IEloquentFiltersPayload a partir de um Request.
     *
     * @param Request $request
     * @return IEloquentFiltersPayload
     */
    public static function makeFromRequest(Request $request): IEloquentFiltersPayload;

    /**
     * Aplica a um query builder recebido por parâmetro, os filtros adequados, se existirem.
     *
     * @param Builder $query
     * @return Builder
     */
    public function applyFilters(Builder $query): Builder;
}
