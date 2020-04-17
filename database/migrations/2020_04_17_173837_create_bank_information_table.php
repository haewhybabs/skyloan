<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_information', function (Blueprint $table) {
            $table->id('idbankinformation');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('idusers')->on('users');
            $table->integer('bank_id')->unsigned();
            $table->foreign('bank_id')->references('idbanks')->on('banks');
            $table->string('account_number');
            $table->string('bvn');
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
        Schema::dropIfExists('bank_information');
    }
}
