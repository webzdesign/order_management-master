<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('state_id')->unsigned()->index();
            $table->foreign('state_id')->references('id')->on('states');
            $table->integer('city_id')->unsigned()->index();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->string('name');
            $table->string('mobile_no');
            $table->longText('address');
            $table->integer('added_by')->unsigned()->index();
            $table->foreign('added_by')->references('id')->on('users');
            $table->integer('updated_by')->default(null)->unsigned()->index();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->boolean('status')->comment('1-activate, 0-deactivate');
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
        Schema::dropIfExists('parties');
    }
}
