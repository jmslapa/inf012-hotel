<?php

namespace Modules\HumanResource\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Auth\Models\Permission;

class Role extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'enabled'];
    protected $hidden = ['deleted_at'];
    protected $casts = ['enabled' => 'boolean'];

    protected static function booted()
    {
        static::addGlobalScope('loadRelations', fn(Builder $q) => $q->with(['permissions']));
    }

    /**
     * Define uma relação 1:n com Employee.
     *
     * @return HasMany
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * Define relação n:n com Permission
     *
     * @return BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}
