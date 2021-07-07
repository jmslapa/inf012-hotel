<?php

use Illuminate\Support\Str;
use Modules\Auth\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\HumanResource\Models\Role;
use Modules\HumanResource\Models\Employee;
use Modules\HumanResource\Models\Administrator;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(Administrator::class)
        ->create()
        ->user()
        ->create(
            factory(User::class)
                ->make(['email' => 'admin@admin', 'password' => 'admin@admin'])
                ->setAppends([])
                ->makeVisible('password')
                ->toArray()
        );
        
        if ($exists = File::exists($path = base_path('.env'))) {
            $content = File::get($path, true);
            $content = str_replace('ADMIN_USER='.env('ADMIN_USER'), "ADMIN_USER={$user->id}", $content);
            File::put($path, $content, true);
            
            $content = File::get($path, true);
            $success = Str::contains($content, [
                "ADMIN_USER={$user->id}",
            ]);
        }
        
        if (!($exists || $success)) {
            throw new \Exception('Unable to generate the admin environment data.');
        }
    }
}
