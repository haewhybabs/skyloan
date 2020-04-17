<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersEmploymentInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_employment_info', function (Blueprint $table) {
            $table->increments('idusersemploymentinfo');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('idusers')->on('users');
            $table->integer('employment_type_id')->unsigned();
            $table->foreign('employment_type_id')->references('idemploymenttype')->on('employment_type');
            $table->string('employer_name');
            $table->integer('employer_lg_id')->unsigned();
            $table->foreign('employer_lg_id')->references('idlgs')->on('lgs');
            $table->string('employer_address');
            $table->integer('salary_range_id')->unsigned();
            $table->foreign('salary_range_id')->references('idsalaryrange')->on('salary_range');
            $table->string('nature_of_job');
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
        Schema::dropIfExists('users_employment_info');
    }
}
