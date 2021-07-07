<?php

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

if (!function_exists('manipulateEloquentCollectionOrPaginator')) {
    /**
     * Manipula uma coleção ou a coleção de um paginator.
     *
     * @param Collection|LengthAwarePaginator $resource
     * @param callable $callback
     * @return Collection|LengthAwarePaginator
     */
    function manipulateEloquentCollectionOrPaginator($resource, callable $callback)
    {
        $isPaginator = $resource instanceof LengthAwarePaginator;
        $col = $isPaginator ? $resource->getCollection() : $resource;
        $col = $callback($col);
        return $isPaginator ? $resource->setCollection($col) : $col;
    }
}
