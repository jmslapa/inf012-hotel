<?php

namespace Modules\Store\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Models\Products\Demandable;

class DemandableOrder extends Model
{
    protected $fillable = [
        'booking_id',
        'demandable_id',
        'amount'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected static function booted()
    {
        static::addGlobalScope('loadDemandable', fn(Builder $q) => $q->with('demandable'));
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function demandable()
    {
        return $this->belongsTo(Demandable::class);
    }

    public function getSubtotal()
    {
        return $this->demandable->calcTotalValue($this->amount);
    }
}
