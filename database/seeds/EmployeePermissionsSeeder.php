<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Modules\Auth\Enums\PolicyMethod;
use Modules\Auth\Interfaces\Services\IPermissionService;
use Modules\Auth\Models\Permission;
use Modules\HumanResource\Models\Employee;

class EmployeePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = new Collection([
            ['name' => 'Listar funcionarios', 'policy_method' => PolicyMethod::VIEW_ANY],
            ['name' => 'Visualizar funcionario', 'policy_method' => PolicyMethod::VIEW],
            ['name' => 'Criar funcionario', 'policy_method' => PolicyMethod::CREATE],
            ['name' => 'Editar funcionario', 'policy_method' => PolicyMethod::UPDATE],
            ['name' => 'Excluir funcionario', 'policy_method' => PolicyMethod::DELETE]
        ]);
        
        $permissions = $permissions->each(fn($p) => factory(Permission::class)->create(
            array_merge($p, ['target' => Employee::class])
        ));
    }
}
