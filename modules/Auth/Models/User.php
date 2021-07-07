<?php

namespace Modules\Auth\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\Guard;
use Laravel\Sanctum\HasApiTokens;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\HumanResource\Models\Administrator;
use Modules\HumanResource\Models\Employee;
use Modules\Store\Models\Customer;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
        'authenticatable_id',
        'authenticatable_type',
        'administrator'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['is_employee', 'is_administrator', 'is_customer'];

    protected static function booted()
    {
        static::addGlobalScope('hideAdmin', fn(Builder $q) =>
            !(calledByClass(AuthController::class) || calledByClass(Guard::class))
            ? $q->whereKeyNot(config('auth.admin.user'))
            : $q);
            
        static::creating(function (User $user) {
            $user->setAttribute('password', bcrypt($user->password));
        });
    }

    public function getIsEmployeeAttribute()
    {
        return $this->authenticatable_type === Employee::class;
    }

    public function getIsAdministratorAttribute()
    {
        return $this->authenticatable_type === Administrator::class;
    }

    public function getIsCustomerAttribute()
    {
        return $this->authenticatable_type === Customer::class;
    }

    /**
     * Define uma relação plimórfica inversa 1:1
     *
     * @return MorphTo
     */
    public function authenticatable()
    {
        return $this->morphTo('authenticatable')->withoutGlobalScope('hideAdmin');
    }
}
