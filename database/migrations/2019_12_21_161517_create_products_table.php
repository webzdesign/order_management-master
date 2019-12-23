<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('name');
            $table->string('image')->nullable();
            $table->double('op_stock');
            $table->double('price');
            $table->integer('added_by')->unsigned()->index();
            $table->foreign('added_by')->references('id')->on('users');
            $table->integer('updated_by')->default(null)->unsigned()->index();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->boolean('status')->comment('0-deactivate, 1-activate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
