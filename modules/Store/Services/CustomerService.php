<?php

namespace Modules\Store\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Store\Services\Payloads\CustomerFiltersPayload;
use Support\Abstracts\Services\EloquentModelService;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class CustomerService extends EloquentModelService
{
    private $filters;

    public function getFilters(): IEloquentFiltersPayload
    {
        if (!($this->filters instanceof IEloquentFiltersPayload)) {
            $this->filters = CustomerFiltersPayload::makeFromRequest(request());
        }
        return $this->filters;
    }

    public function create(array $data): object
    {
        return DB::transaction(function () use ($data) {
            $customer = parent::create($data);
            $customer->user()->create(collect($data)->only($customer->user()->getModel()->getFillable())->all());
            $customer->address()->create($data['address']);
            $customer->phones()->createMany($data['phones']);
            return $this->find($customer->id);
        });
    }

    public function update(object $model, array $data): object
    {
        $address = $model->address;
        $address->fill($data['address']);
        $model->fill($data);
        
        if ($address->isDirty()) {
            $address->save();
        }

        return parent::update($model, $data);
    }

    public function delete(object $model): void
    {
        if ($model->address !== null) {
            $model->address->delete();
        }

        if ($model->phones()->count() > 0) {
            $model->phones()->delete();
        }

        parent::delete($model);
    }

    /**
     * Adiciona um telefone
     *
     * @param Model $customer
     * @param string $number
     * @return Model
     */
    public function addPhone(Model $customer, string $number)
    {
        $customer->phones()->create(['number' => $number]);
        return $this->find($customer->id);
    }

    /**
     * Remove um telefone
     *
     * @param Model $customer
     * @param integer $phoneId
     * @return Model
     */
    public function removePhone(Model $customer, int $phoneId)
    {
        $customer->phones()->where('id', $phoneId)->delete();
        return $this->find($customer->id);
    }
}
