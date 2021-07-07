<?php

namespace Modules\Store\Services\Payloads;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Modules\Common\Services\Payloads\AddressFiltersPayload;
use Modules\Common\Services\Payloads\PhoneFiltersPayload;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class CustomerFiltersPayload implements IEloquentFiltersPayload
{
    private $addressFilters;
    private $phoneFilters;
    private $name;
    private $nationality;
    private $birth;
    private $cpf;
    private $enabled;

    private function __construct(
        IEloquentFiltersPayload $addressFilters,
        IEloquentFiltersPayload $phoneFilters,
        ?string $name,
        ?string $nationality,
        ?string $birth,
        ?string $cpf,
        ?bool $enabled
    ) {
        $this->addressFilters = $addressFilters;
        $this->phoneFilters = $phoneFilters;
        $this->name = $name;
        $this->nationality = $nationality;
        $this->birth = $birth;
        $this->cpf = $cpf;
        $this->enabled = $enabled;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function getBirth(): ?string
    {
        return $this->birth;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public static function makeFromRequest(Request $request): IEloquentFiltersPayload
    {
        return new CustomerFiltersPayload(
            AddressFiltersPayload::makeFromRequest($request),
            PhoneFiltersPayload::makeFromRequest($request),
            $request->query('name'),
            $request->query('nationality'),
            $request->query('birth'),
            $request->query('cpf'),
            $request->query('enabled')
        );
    }

    public function applyFilters(Builder $query): Builder
    {
        return $query
            ->whereHas('address', fn(Builder $q) => $this->addressFilters->applyFilters($q))
            ->whereHas('phones', fn(Builder $q) => $this->phoneFilters->applyFilters($q))
            ->when($this->name !== null, fn(Builder $q) => $q->where('name', 'like', "%{$this->name}%"))
            ->when($this->birth !== null, fn(Builder $q) => $q->where('birth', 'like', "%{$this->birth}%"))
            ->when($this->cpf !== null, fn(Builder $q) => $q->where('cpf', 'like', "%{$this->cpf}%"))
            ->when($this->enabled !== null, fn(Builder $q) => $q->where('enabled', $this->enabled))
            ->when($this->nationality !== null, fn(Builder $q) =>
                $q->where('nationality', 'like', "%{$this->nationality}%"));
    }
}
