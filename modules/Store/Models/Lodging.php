<?php

namespace Modules\Store\Models;

use Illuminate\Database\Eloquent\Model;

class Lodging extends Model
{
    protected $fillable = [];

    protected $hidden = ['deleted_at'];

    protected $dates = ['check_in', 'check_out'];

    protected static function booted()
    {
        static::creating(fn(Lodging $l) => $l->check_in = now());
    }

    public function isActive()
    {
        return $this->check_in !== null && $this->check_out === null;
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
