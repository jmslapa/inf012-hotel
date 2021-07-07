<?php

namespace Modules\Common\Services\Payloads;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class AddressFiltersPayload implements IEloquentFiltersPayload
{
    private $zip;
    private $number;
    private $address;
    private $complement;
    private $district;
    private $city;
    private $state;
    private $enable;

    private function __construct(
        ?string $zip,
        ?string $number,
        ?string $address,
        ?string $complement,
        ?string $district,
        ?string $city,
        ?string $state,
        ?bool $enable
    ) {
        $this->zip = $zip;
        $this->number = $number;
        $this->address = $address;
        $this->complement = $complement;
        $this->district = $district;
        $this->city = $city;
        $this->state = $state;
        $this->enable = $enable;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }
    
    public function getNumber(): ?string
    {
        return $this->number;
    }
    
    public function getAddress(): ?string
    {
        return $this->address;
    }
    
    public function getComplement(): ?string
    {
        return $this->complement;
    }
    
    public function getDistrict(): ?string
    {
        return $this->district;
    }
    
    public function getCity(): ?string
    {
        return $this->city;
    }
    
    public function getState(): ?string
    {
        return $this->state;
    }
    
    public function getEnable(): ?bool
    {
        return $this->enable;
    }
    
    public static function makeFromRequest(Request $request): IEloquentFiltersPayload
    {
        return new AddressFiltersPayload(
            $request->query('zip'),
            $request->query('number'),
            $request->query('address'),
            $request->query('complement'),
            $request->query('district'),
            $request->query('city'),
            $request->query('state'),
            $request->query('enable')
        );
    }

    public function applyFilters(Builder $query): Builder
    {
        return $query
            ->when($this->zip !== null, fn(Builder $q) => $q->where('zip', 'like', "%{$this->zip}%"))
            ->when($this->number !== null, fn(Builder $q) => $q->where('number', 'like', "%{$this->number}%"))
            ->when($this->address !== null, fn(Builder $q) => $q->where('address', 'like', "%{$this->address}%"))
            ->when($this->district !== null, fn(Builder $q) => $q->where('district', 'like', "%{$this->district}%"))
            ->when($this->city !== null, fn(Builder $q) => $q->where('city', 'like', "%{$this->city}%"))
            ->when($this->state !== null, fn(Builder $q) => $q->where('state', 'like', "%{$this->state}%"))
            ->when($this->enable !== null, fn(Builder $q) => $q->where('enable', $this->enable))
            ->when($this->complement !== null, fn(Builder $q) =>
                $q->where('complement', 'like', "%{$this->complement}%"));
    }
}
