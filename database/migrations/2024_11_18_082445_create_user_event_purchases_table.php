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
            $table->bigInteger('user_id');
            $table->bigInteger('event_id');
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
            $table->text('paymentLink')->nullable();
            $table->integer('paymentStatus')->default(2);
            $table->string('datePaid')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('user_event_purchases');
    }
}
