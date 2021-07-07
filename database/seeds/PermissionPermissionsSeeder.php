<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Modules\Auth\Enums\PolicyMethod;
use Modules\Auth\Interfaces\Services\IPermissionService;
use Modules\Auth\Models\Permission;

class PermissionPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = new Collection([
            ['name' => 'Listar permissões', 'policy_method' => PolicyMethod::VIEW_ANY]
        ]);
        
        $permissions = $permissions->each(fn($p) => factory(Permission::class)->create(
            array_merge($p, ['target' => Permission::class])
        ));
    }
}
