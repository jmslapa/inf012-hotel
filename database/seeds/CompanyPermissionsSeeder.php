<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Modules\Auth\Enums\PolicyMethod;
use Modules\Auth\Models\Permission;
use Modules\Company\Models\Company;

class CompanyPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = new Collection([
            ['name' => 'Listar empresas', 'policy_method' => PolicyMethod::VIEW_ANY],
            ['name' => 'Visualizar empresa', 'policy_method' => PolicyMethod::VIEW],
            // ['name' => 'Criar empresa', 'policy_method' => PolicyMethod::CREATE],
            ['name' => 'Editar empresa', 'policy_method' => PolicyMethod::UPDATE],
            // ['name' => 'Excluir empresa', 'policy_method' => PolicyMethod::DELETE]
        ]);
        
        $permissions = $permissions->each(fn($p) => factory(Permission::class)->create(
            array_merge($p, ['target' => Company::class])
        ));
    }
}
