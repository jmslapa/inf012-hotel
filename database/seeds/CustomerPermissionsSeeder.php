<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Modules\Auth\Enums\PolicyMethod;
use Modules\Auth\Models\Permission;
use Modules\Store\Models\Customer;

class CustomerPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = new Collection([
            ['name' => 'Listar clientes', 'policy_method' => PolicyMethod::VIEW_ANY],
            ['name' => 'Visualizar cliente', 'policy_method' => PolicyMethod::VIEW],
            ['name' => 'Criar cliente', 'policy_method' => PolicyMethod::CREATE],
            ['name' => 'Editar cliente', 'policy_method' => PolicyMethod::UPDATE],
            ['name' => 'Excluir cliente', 'policy_method' => PolicyMethod::DELETE]
        ]);
        
        $permissions = $permissions->each(fn($p) => factory(Permission::class)->create(
            array_merge($p, ['target' => Customer::class])
        ));
    }
}
