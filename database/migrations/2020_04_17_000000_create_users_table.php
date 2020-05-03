<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('idusers');
            $table->string('fullname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('status')->nullable();
            $table->integer('phone_number');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('idroles')->on('roles');
            $table->string('sex')->nullable();
            $table->integer('lg_id')->unsigned()->nullable();
            $table->foreign('lg_id')->references('idlgs')->on('lgs');
            $table->integer('state_id')->unsigned()->nullable();
            $table->foreign('state_id')->references('idstates')->on('states');
            $table->string('address')->nullable();
            $table->integer('marital_status')->nullable();
            $table->foreign('marital_status')->references('idmaritalstatus')->on('marital_status');
            $table->date('dob');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
