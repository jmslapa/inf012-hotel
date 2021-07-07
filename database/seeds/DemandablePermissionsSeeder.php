<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Modules\Auth\Enums\PolicyMethod;
use Modules\Auth\Models\Permission;
use Modules\Product\Models\Products\Demandable;

class DemandablePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = new Collection([
            ['name' => 'Listar demandáveis', 'policy_method' => PolicyMethod::VIEW_ANY],
            ['name' => 'Visualizar demandável', 'policy_method' => PolicyMethod::VIEW],
            ['name' => 'Criar demandável', 'policy_method' => PolicyMethod::CREATE],
            ['name' => 'Editar demandável', 'policy_method' => PolicyMethod::UPDATE],
            ['name' => 'Excluir demandável', 'policy_method' => PolicyMethod::DELETE]
        ]);
        
        $permissions = $permissions->each(fn($p) => factory(Permission::class)->create(
            array_merge($p, ['target' => Demandable::class])
        ));
    }
}
