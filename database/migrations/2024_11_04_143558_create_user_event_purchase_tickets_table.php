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
            $table->string('charge', 100)->default(0);
            $table->string('currency', 10);
            $table->timestamps();

            $table->foreign('event_id', 'user_event_purchase_tickets_event_id_foreign')->references('id')->on('user_events')->onDelete('cascade');
            $table->foreign('ticket_id', 'user_event_purchase_tickets_ticket_id_foreign')->references('id')->on('user_event_tickets')->onDelete('cascade');
            $table->foreign('user_event_purchase_id', 'user_event_purchase_tickets_user_event_purchase_id_foreign')->references('id')->on('user_event_purchases')->onDelete('cascade');
            $table->foreign('user_id', 'user_event_purchase_tickets_user_id_foreign')->references('id')->on('users')->onDelete('cascade');
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
