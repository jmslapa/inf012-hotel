<?php

namespace Modules\Common\Services\Payloads;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class PhoneFiltersPayload implements IEloquentFiltersPayload
{
    private $number;
    private $enable;

    private function __construct(
        ?string $number,
        ?bool $enable
    ) {
        $this->number = $number;
        $this->enable = $enable;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    public static function makeFromRequest(Request $request): IEloquentFiltersPayload
    {
        return new PhoneFiltersPayload(
            $request->query('number'),
            $request->query('enable')
        );
    }

    public function applyFilters(Builder $query): Builder
    {
        return $query
            ->when($this->number !== null, fn(Builder $q) => $q->where('number', 'like', "%{$this->number}%"))
            ->when($this->enable !== null, fn(Builder $q) => $q->where('enable', $this->enable));
    }
}
