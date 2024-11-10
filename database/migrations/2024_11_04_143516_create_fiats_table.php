<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('sign');
            $table->string('rate', 200)->default('500');
            $table->string('country', 150)->nullable();
            $table->integer('hasPayout')->default(1);
            $table->string('minAmount', 150)->default('100');
            $table->string('payoutFee', 150)->default('0.3');
            $table->string('charge', 50)->default('1.5');
            $table->string('maxCharge', 150)->default('3000');
            $table->string('fixedPayoutFee', 150)->default('0');
            $table->integer('hasWithdrawalCap')->default(2);
            $table->string('withdrawalCap', 150)->default('0');
            $table->string('transactionCharge', 100)->default('100');
            $table->string('subUnit', 100)->default('100');
            $table->integer('ticketChargeType')->default(1);
            $table->string('ticketCharge', 100)->default('1.5');
            $table->string('ticketFixedCharge', 100)->default('1');
            $table->boolean('hasTicketFixedCharge')->default(1);
            $table->string('ticketAmountToAddToCharge')->default('2500')->comment('this is the amount which when below it, the fixed charge is added to the cost instead of debiting it from amount.');
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
        Schema::dropIfExists('fiats');
    }
}
