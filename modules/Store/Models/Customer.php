<?php

namespace Modules\Store\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Auth\Models\User;
use Modules\Common\Models\Address;
use Modules\Common\Models\Phone;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'nationality',
        'birth',
        'cpf',
        'enabled',
    ];

    protected $dates = [
        'birth'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected $casts = [
        'enabled' => 'boolean'
    ];

    protected static function booted()
    {
        static::addGlobalScope('loadRelations', fn(Builder $q) => $q->with(['user', 'phones', 'address']));
    }

    /**
     * Define uma relação polimórfica 1:1 com User.
     *
     * @return MorphOne
     */
    public function user()
    {
        return $this->morphOne(User::class, 'authenticatable');
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
     * @return void
     */
    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
