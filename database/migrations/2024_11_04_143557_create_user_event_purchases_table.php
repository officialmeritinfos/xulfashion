<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEventPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_event_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->integer('bulkPurchase')->default(2);
            $table->unsignedBigInteger('user_id')->index('user_event_purchases_user_id_foreign');
            $table->unsignedBigInteger('event_id');
            $table->string('buyer', 100)->nullable();
            $table->string('purchaseCurrency', 100);
            $table->string('conversionRate', 100)->nullable();
            $table->string('conversionAmount', 200)->nullable();
            $table->integer('converted')->default(2);
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
            
            $table->foreign('event_id', 'user_event_purchases_event_id_foreign')->references('id')->on('user_events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_event_purchases');
    }
}
