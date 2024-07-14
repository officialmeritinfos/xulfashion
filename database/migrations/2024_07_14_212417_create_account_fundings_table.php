<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountFundingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_fundings', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('user');
            $table->string('reference', 150)->nullable();
            $table->string('amount', 150)->nullable();
            $table->string('currency', 150)->nullable();
            $table->string('charge', 150)->nullable();
            $table->string('amountCredit', 150)->nullable();
            $table->string('channel', 150)->nullable();
            $table->string('transactionReference', 150)->nullable();
            $table->string('paymentReference', 150)->nullable();
            $table->string('transactionHash', 150)->nullable();
            $table->integer('status')->default(2);
            $table->timestamps(, 150);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_fundings');
    }
}
