<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEventTicketBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_event_ticket_buyers', function (Blueprint $table) {
            $table->id();
            $table->string('user', 150);
            $table->string('event', 150);
            $table->string('ticket', 150)->nullable();
            $table->string('purchaseId', 150)->nullable();
            $table->string('isGroup', 150)->default('2');
            $table->string('email', 150)->nullable();
            $table->string('name', 150)->nullable();
            $table->string('phone', 150)->nullable();
            $table->string('country', 150)->nullable();
            $table->longText('questions');
            $table->longText('answers');
            $table->integer('isFree')->default(2);
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
        Schema::dropIfExists('user_event_ticket_buyers');
    }
}
