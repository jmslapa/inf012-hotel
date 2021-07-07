<?php

use Illuminate\Database\Seeder;
use Modules\Common\Models\Address;
use Modules\Company\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Company::class)
            ->create()
            ->address()
            ->create(
                factory(Address::class)
                    ->make()
                    ->toArray()
            );
    }
}
