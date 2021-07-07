<?php

namespace Modules\Common\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'zip',
        'number',
        'address',
        'complement',
        'district',
        'city',
        'state',
    ];

    protected $hidden = [
        'addressable_type',
        'addressable_id',
        'deleted_at'
    ];
}
