<?php

namespace Modules\Common\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $table = 'phones';

    protected $fillable = [
        'number',
        'enable',
    ];

    protected $hidden = [
        'callable_type',
        'callable_id',
        'deleted_at'
    ];
}
