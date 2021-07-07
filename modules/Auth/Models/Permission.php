<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\HumanResource\Models\Role;

class Permission extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'target', 'police_method', 'enabled'];
    protected $hidden = ['target', 'policy_method', 'deleted_at'];
    protected $casts = ['enabled' => 'boolean'];

    /**
     * Define relacionamento n:n com Role
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }
}
