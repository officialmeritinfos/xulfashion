<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_cart_id');
            $table->unsignedBigInteger('user_event_ticket_id');
            $table->integer('quantity');
            $table->timestamps();
            
            $table->foreign('ticket_cart_id', 'ticket_cart_items_ticket_cart_id_foreign')->references('id')->on('ticket_carts')->onDelete('cascade');
            $table->foreign('user_event_ticket_id', 'ticket_cart_items_user_event_ticket_id_foreign')->references('id')->on('user_event_tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_cart_items');
    }
}
