<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->string('order_no');
            $table->date('date');
            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')->on('products');
            $table->double('qty');
            $table->integer('dealer_id')->unsigned()->index();
            $table->foreign('dealer_id')->references('id')->on('dealers');
            $table->integer('city_id')->unsigned()->index();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->string('instruction');
            $table->double('dispatch_qty')->default('0');
            $table->double('remaining_qty')->default('0');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->double('status')->default('0')->comment('0-pending, 1-partial pending, 2-partial');
            $table->string('transporter');
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
        Schema::dropIfExists('orders');
    }
}
