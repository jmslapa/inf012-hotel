<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Modules\Auth\Enums\PolicyMethod;
use Modules\Auth\Interfaces\Services\IPermissionService;
use Modules\Auth\Models\Permission;
use Modules\HumanResource\Models\Role;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = new Collection([
            ['name' => 'Listar cargos', 'policy_method' => PolicyMethod::VIEW_ANY],
            ['name' => 'Visualizar cargo', 'policy_method' => PolicyMethod::VIEW],
            ['name' => 'Criar cargo', 'policy_method' => PolicyMethod::CREATE],
            ['name' => 'Editar cargo', 'policy_method' => PolicyMethod::UPDATE],
            ['name' => 'Excluir cargo', 'policy_method' => PolicyMethod::DELETE]
        ]);
        
        $permissions = $permissions->each(fn($p) => factory(Permission::class)->create(
            array_merge($p, ['target' => Role::class])
        ));
    }
}
