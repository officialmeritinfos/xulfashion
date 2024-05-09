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
            $table->bigInteger('id')->primary();
            $table->string('user', 150)->nullable();
            $table->string('reference', 150);
            $table->string('transactionType', 150)->nullable();
            $table->string('withdrawalRef', 150)->nullable();
            $table->string('amount', 150)->nullable();
            $table->string('currency', 150)->nullable();
            $table->string('newBalance', 100);
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
        Schema::dropIfExists('transactions');
    }
}
