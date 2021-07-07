<?php

namespace Modules\Company\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Common\Models\Address;
use Modules\Common\Models\Phone;

class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = [
        'name',
        'category',
        'email',
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected static function booted()
    {
        static::addGlobalScope('loadRelations', fn(Builder $q) => $q->with(['address', 'phones']));

        static::creating(function () {
            if (!calledByClass(\CompanySeeder::class)) {
                abort(403);
            }
        });

        static::deleting(function () {
            abort(403);
        });
    }

    /**
     * Define uma relacao polimórfica 1:n com Phone
     *
     * @return MorphMany
     */
    public function phones()
    {
        return $this->morphMany(Phone::class, 'callable');
    }

    /**
     * Define uma relacao polimórfica 1:1 com address
     *
     * @return MorphOne
     */
    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
