<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_category', function (Blueprint $table) {
            $table->integer('product_id')
                ->unsigned()
                ->index();
            $table->integer('category_id')
                ->unsigned()
                ->index();

            $table->foreign('product_id')
                ->references('id')
                ->on('product')
                ->onDelete('cascade');
            $table->foreign('category_id')
                ->references('id')
                ->on('category')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_category');
    }
}
