<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEventPurchaseTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_event_purchase_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_event_purchase_id');
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('number_admits');
            $table->integer('quantity');
            $table->string('price', 100);
            $table->string('currency', 10);
            $table->string('charge', 100)->default('0');
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
        Schema::dropIfExists('user_event_purchase_tickets');
    }
}
