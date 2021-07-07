<?php

namespace Modules\HumanResource\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Auth\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'cpf', 'gender', 'enabled', 'role_id'];
    protected $hidden = ['deleted_at'];
    protected $casts = ['enabled' => 'boolean'];

    protected static function booted()
    {
        static::addGlobalScope('loadRelations', fn(Builder $q) => $q->with(['user', 'role.permissions']));
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
     * Define uma relação inversa 1:n com Role.
     *
     * @return BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
