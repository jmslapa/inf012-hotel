<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryRentableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_rentable', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('rentable_id');
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->primary(['category_id', 'rentable_id']);
            $table->foreign('category_id', 'fk_category_rentable_category_id')
                ->references('id')
                ->on('rentable_categories');
            $table->foreign('rentable_id', 'fk_category_rentable_rentable_id')
                ->references('id')
                ->on('rentables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_rentable');
    }
}
