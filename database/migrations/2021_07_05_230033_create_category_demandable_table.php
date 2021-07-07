<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryDemandableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_demandable', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('demandable_id');
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->primary(['category_id', 'demandable_id']);
            $table->foreign('category_id', 'fk_category_demandable_category_id')
                ->references('id')
                ->on('demandable_categories');
            $table->foreign('demandable_id', 'fk_category_demandable_demandable_id')
                ->references('id')
                ->on('demandables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_demandable');
    }
}
