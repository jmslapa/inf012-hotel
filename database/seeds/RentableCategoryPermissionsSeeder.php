<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Modules\Auth\Enums\PolicyMethod;
use Modules\Auth\Models\Permission;
use Modules\Product\Models\Categories\RentableCategory;

class RentableCategoryPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = new Collection([
            ['name' => 'Listar categorias de alugáveis', 'policy_method' => PolicyMethod::VIEW_ANY],
            ['name' => 'Visualizar categoria de alugável', 'policy_method' => PolicyMethod::VIEW],
            ['name' => 'Criar categoria de alugável', 'policy_method' => PolicyMethod::CREATE],
            ['name' => 'Editar categoria de alugável', 'policy_method' => PolicyMethod::UPDATE],
            ['name' => 'Excluir categoria de alugável', 'policy_method' => PolicyMethod::DELETE]
        ]);
        
        $permissions = $permissions->each(fn($p) => factory(Permission::class)->create(
            array_merge($p, ['target' => RentableCategory::class])
        ));
    }
}
