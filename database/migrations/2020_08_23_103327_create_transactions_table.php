<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('status');
            $table->integer('amount');
            $table->string('currency');
            $table->timestamps();


            $table->integer('source_account_id')->unsigned();
            $table->foreign('source_account_id')->references('id')->on('accounts');

            
            $table->integer('destination_account_id')->unsigned();
            $table->foreign('destination_account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
