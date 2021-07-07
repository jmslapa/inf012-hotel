<?php

namespace Support\Abstracts\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Support\Interfaces\Services\IEloquentModelService;
use Support\Interfaces\Services\IModelService;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

abstract class EloquentModelService implements IEloquentModelService, IModelService
{
    protected $isPaginationEnabled = true;
    protected $isFilteringEnabled = true;
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Deve retornar um payload com os filtros.
     *
     * @return IEloquentFiltersPayload
     */
    abstract public function getFilters(): IEloquentFiltersPayload;

    final public function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    final public function listOrPaginate(Builder $query, ?IEloquentFiltersPayload $filters = null)
    {
        $page = request('page', false);
        $perPage = request('per_page', false);
        $query = $this->isFilteringEnabled ? $filters->applyFilters($query) : $query;
        return $this->isPaginationEnabled && $page && $perPage && $perPage > 0
            ? $query->paginate($perPage)
            : $query->get();
    }

    final public function disablePagination()
    {
        $this->isPaginationEnabled = false;
        return $this;
    }

    final public function enablePagination()
    {
        $this->isPaginationEnabled = true;
        return $this;
    }

    final public function disableFiltering()
    {
        $this->isFilteringEnabled = false;
        return $this;
    }

    final public function enableFiltering()
    {
        $this->isFilteringEnabled = true;
        return $this;
    }

    public function all()
    {
        return $this->listOrPaginate($this->newQuery(), $this->getFilters());
    }

    /**
     * @return Model
     */
    public function find(int $id): object
    {
        $resource = $this->newQuery()->find($id);
        if ($resource === null) {
            abort(404, 'Resource not found.');
        }
        return $resource;
    }

    /**
     * @return Model
     */
    public function create(array $data): object
    {
        return $this->find($this->newQuery()->create($data)->id);
    }

    /**
     * @param Model $model
     * @return Model
     */
    public function update(object $model, array $data): object
    {
        $model->fill($data);
        if ($model->isDirty()) {
            $model->save();
        }
        return $this->find($model->id);
    }

    /**
     * @param Model $model
     */
    public function delete(object $model): void
    {
        $model->delete();
    }
}
