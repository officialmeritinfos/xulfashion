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
        Schema::create('user_event_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->string('type')->nullable();
            $table->integer('bulkPurchase')->default(2);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained('user_events')->onDelete('cascade');
            $table->foreignId('ticket_id')->constrained('user_event_tickets')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->string('price');
            $table->string('totalPrice');
            $table->string('paymentReference')->nullable();
            $table->string('paymentMethod')->nullable();
            $table->string('paymentId')->nullable();
            $table->string('charge')->nullable();
            $table->string('totalCharge')->nullable();
            $table->string('processorFee')->nullable();
            $table->integer('paymentStatus')->default(2);
            $table->string('datePaid')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_event_purchases');
    }
};
