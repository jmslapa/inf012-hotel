<?php

namespace Modules\HumanResource\Models;

use AdministratorSeeder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;
use Modules\Auth\Enums\PolicyMethod;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Models\User;

class Administrator extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['user_id', 'enabled'];
    protected $hidden = ['deleted_at'];
    protected $casts = ['enabled' => 'boolean'];

    protected static function booted()
    {
        if (!(calledByClass(AdministratorSeeder::class) || calledByClass(AuthController::class))) {
            Gate::authorize(PolicyMethod::CREATE, self::class);
        }

        static::addGlobalScope('hideAdmin', fn(Builder $q) => $q->whereKey(null));
    }

    /**
     * Relacionamento 1:1 inverso com User
     *
     * @return MorphOne
     */
    public function user()
    {
        return $this->morphOne(User::class, 'authenticatable')->withoutGlobalScope('hideAdmin');
    }
}
