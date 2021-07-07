<?php

namespace Support\Interfaces\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

interface IEloquentModelService
{
    /**
     * Retorna uma instância de um EloquentBuilder
     *
     * @return Builder
     */
    public function newQuery(): Builder;
    /**
     * Executa paginação mediante a detecção dos parâmetros necessários.
     *
     * @param Builder $query
     * @param IEloquentFiltersPayload $filters
     * @return LengthAwarePaginator|Collection;
     */
    public function listOrPaginate(Builder $query, IEloquentFiltersPayload $filters = null);
}
