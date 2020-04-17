<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('idloans');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('idusers')->on('users');
            $table->integer('loan_range_id')->unsigned();
            $table->foreign('loan_range_id')->references('idloanrange')->on('loan_range');
            $table->integer('loan_status_id')->unsigned();
            $table->foreign('loan_status_id')->references('idloanstatus')->on('loan_status');
            $table->date('loan_start_date');
            $table->integer('loan_duration_id')->unsigned();
            $table->foreign('loan_duration_id')->references('idloanduration')->on('loan_duration');
            $table->string('loan_info');
            $table->string('amount');
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
        Schema::dropIfExists('loan');
    }
}
