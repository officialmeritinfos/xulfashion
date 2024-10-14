<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEventSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_event_settlements', function (Blueprint $table) {
            $table->id();
            $table->string('user', 150)->nullable();
            $table->string('event', 150)->nullable();
            $table->string('reference', 150)->default('');
            $table->string('amount', 150)->nullable();
            $table->string('currency', 150)->nullable();
            $table->string('payoutAccount', 150)->nullable();
            $table->integer('type')->default(1);
            $table->string('transactionId', 150);
            $table->string('payoutStatus', 150);
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
        Schema::dropIfExists('user_event_settlements');
    }
}
