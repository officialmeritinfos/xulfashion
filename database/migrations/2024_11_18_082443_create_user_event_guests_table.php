<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEventGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_event_guests', function (Blueprint $table) {
            $table->id();
            $table->string('user', 150)->nullable();
            $table->string('event', 150)->nullable();
            $table->string('ticket_id', 150)->nullable();
            $table->unsignedBigInteger('purchase');
            $table->string('ticketCode', 150)->nullable();
            $table->integer('checkedIn')->default(2);
            $table->string('email', 150)->nullable();
            $table->string('name', 150)->nullable();
            $table->string('phone', 150)->nullable();
            $table->boolean('sameAsBuyer')->default(0);
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('user_event_guests');
    }
}
