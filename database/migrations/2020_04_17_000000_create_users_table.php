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
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('idroles')->on('roles');
            $table->string('sex');
            $table->integer('lg_id')->unsigned();
            $table->foreign('lg_id')->references('idlgs')->on('lgs');
            $table->string('address');
            $table->string('marital_status');
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
