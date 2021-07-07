<?php

namespace Modules\Store\Services\Payloads;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class BookingFiltersPayload implements IEloquentFiltersPayload
{
    private $start;
    private $end;
    private $status;
    private $customer;

    public function __construct(?Carbon $start, ?Carbon $end, ?string $status, ?string $customer)
    {
        $this->start = $start;
        $this->end = $end;
        $this->status = $status;
        $this->customer = $customer;
    }

    public function getStart(): ?Carbon
    {
        return $this->start;
    }

    public function getEnd(): ?Carbon
    {
        return $this->end;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    public static function makeFromRequest(Request $request): IEloquentFiltersPayload
    {
        return new BookingFiltersPayload(
            $request->query('start') ? Carbon::createFromFormat('d/m/Y', $request->query('start')) : null,
            $request->query('end') ? Carbon::createFromFormat('d/m/Y', $request->query('end')) : null,
            $request->query('status'),
            $request->query('customer')
        );
    }

    public function applyFilters(Builder $query): Builder
    {
        return $query->when($this->customer !== null, function (Builder $query) {
            return $query->whereHas('customer', fn (Builder $q) => $q->where('name', 'like', "%{$this->customer}%"));
        })
            ->when($this->start !== null, fn (Builder $q) => $q->where('start', '>=', $this->start))
            ->when($this->end !== null, fn (Builder $q) => $q->where('end', '<=', $this->end))
            ->when($this->status !== null, fn (Builder $q) => $q->where('status', $this->status));
    }
}
