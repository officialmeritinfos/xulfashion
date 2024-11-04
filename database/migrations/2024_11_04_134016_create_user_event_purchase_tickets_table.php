<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
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
            $table->timestamps();
            // Foreign keys
            $table->foreign('user_event_purchase_id')->references('id')->on('user_event_purchases')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('user_events')->onDelete('cascade');
            $table->foreign('ticket_id')->references('id')->on('user_event_tickets')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_event_purchase_tickets');
    }
};
