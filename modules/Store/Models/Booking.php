<?php

namespace Modules\Store\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Modules\Store\Enums\Status;
use Modules\Store\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Models\Products\Rentable;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'rentable_id',
        'start',
        'end',
        'status',
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected $dates = [
        'start',
        'end'
    ];

    protected static function booted()
    {
        static::addGlobalScope('loadRelations', fn(Builder $q) =>
            $q->with(['customer', 'demandables', 'rentable', 'lodging']));
    }

    public function isPending(): bool
    {
        return $this->status === Status::PENDING;
    }

    public function isFinished(): bool
    {
        return $this->status === Status::FINISHED;
    }

    public function isCancelled(): bool
    {
        return $this->status === Status::CANCELLED;
    }

    public function getRangeOfDays(): int
    {
        return $this->start->diffInDays($this->end);
    }

    public function getSubtotal(): float
    {
        $demandablesSubtotal = $this->demandables->reduce(function ($acc, $d) {
            $acc = bcadd(
                $acc,
                $d->getSubtotal(),
                2
            );
            return $acc;
        }, 0);

        $rentableSubtotal = $this->rentable->calcRentalValue($this->start, $this->end);

        return (float) bcadd($demandablesSubtotal, $rentableSubtotal, 2);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function rentable()
    {
        return $this->belongsTo(Rentable::class);
    }

    public function demandables()
    {
        return $this->hasMany(DemandableOrder::class);
    }

    public function lodging()
    {
        return $this->hasOne(Lodging::class);
    }
}
