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
            $table->integer('party_id')->unsigned()->index();
            $table->foreign('party_id')->references('id')->on('parties');
            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')->on('products');
            $table->double('price');
            $table->double('qty');
            $table->double('amount');
            $table->double('discount')->default(0);
            $table->boolean('gst_type')->comment('0-inter state, 1-out of state');
            $table->double('cgst')->default(0);
            $table->double('sgst')->default(0);
            $table->double('igst')->default(0);
            $table->double('cgst_per')->default(0);
            $table->double('sgst_per')->default(0);
            $table->double('igst_per')->default(0);
            $table->double('grand_total');
            $table->string('instruction');
            $table->double('dispatch_qty')->default('0');
            $table->double('remaining_qty')->default('0');
            $table->integer('added_by')->unsigned()->index();
            $table->foreign('added_by')->references('id')->on('users');
            $table->integer('updated_by')->nullable()->unsigned()->index();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->double('status')->default('0')->comment('0-pending, 1-dispatch');
            $table->string('lr_no')->nullable();
            $table->string('transporter')->nullable();
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
