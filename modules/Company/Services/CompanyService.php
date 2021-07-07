<?php

namespace Modules\Company\Services;

use Illuminate\Support\Facades\DB;
use Modules\Company\Services\Payloads\CompanyFilterPayload;
use Support\Abstracts\Services\EloquentModelService;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class CompanyService extends EloquentModelService
{
    public function getFilters(): IEloquentFiltersPayload
    {
        return CompanyFilterPayload::makeFromRequest(request());
    }

    public function create(array $data): object
    {
        return DB::transaction(function () use ($data) {
            $company = parent::create($data);
            $company->address()->create($data['address']);
            $company->phones()->createMany($data['phones']);
            return $this->find($company->id);
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
