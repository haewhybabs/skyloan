<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNextOfKinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('next_of_kin', function (Blueprint $table) {
            $table->increments('idnextofkin');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('idusers')->on('users');
            $table->integer('phone_number');
            $table->string('email');
            $table->integer('state_id')->unsigned();
            $table->foreign('state_id')->references('idstates')->on('states');
            $table->integer('lg_id')->unsigned();
            $table->foreign('lg_id')->references('idlgs')->on('lgs');
            $table->string('address');
            $table->integer('relationship_id')->unsigned();
            $table->foreign('relationship_id')->references('idrelationship')->on('relationship');
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
        Schema::dropIfExists('next_of_kin');
    }
}
