<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Modules\Auth\Enums\PolicyMethod;
use Modules\Auth\Models\Permission;
use Modules\Product\Models\Products\Rentable;

class RentablePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = new Collection([
            ['name' => 'Listar alugáveis', 'policy_method' => PolicyMethod::VIEW_ANY],
            ['name' => 'Visualizar alugável', 'policy_method' => PolicyMethod::VIEW],
            ['name' => 'Criar alugável', 'policy_method' => PolicyMethod::CREATE],
            ['name' => 'Editar alugável', 'policy_method' => PolicyMethod::UPDATE],
            ['name' => 'Excluir alugável', 'policy_method' => PolicyMethod::DELETE]
        ]);
        
        $permissions = $permissions->each(fn($p) => factory(Permission::class)->create(
            array_merge($p, ['target' => Rentable::class])
        ));
    }
}
