<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $policyMethods = [
            'viewAny',
            'view',
            'create',
            'update',
            'delete'
        ];

        Schema::create('permissions', function (Blueprint $table) use ($policyMethods) {
            $table->id();
            $table->string('name');
            $table->string('target');
            $table->enum('policy_method', $policyMethods);
            $table->boolean('enabled')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
