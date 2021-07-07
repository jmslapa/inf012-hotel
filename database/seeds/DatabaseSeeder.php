<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $files = collect(File::allFiles(__DIR__))->filter(
                fn($f) => $f->getExtension() === 'php' && $f->getPathName() !== __FILE__
            );

            $files->each(function ($f) {
                $className = str_replace('.php', '', $f->getRelativePathName());
                if (class_exists($className) && (new ReflectionClass($className))->isSubclassOf(Seeder::class)) {
                    $this->call($className);
                }
            });
        });
    }
}
