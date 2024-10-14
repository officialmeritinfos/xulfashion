<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_orders', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('store');
            $table->string('reference', 150)->nullable();
            $table->string('customer', 150)->nullable();
            $table->string('paymentMethod', 150)->nullable();
            $table->integer('paymentStatus')->default(2);
            $table->string('amount', 150)->nullable();
            $table->string('amountPaid', 150)->nullable();
            $table->string('coupon', 150)->nullable();
            $table->string('charge', 150)->nullable();
            $table->string('processorFee', 150)->default('0');
            $table->string('affiliateAmount', 150)->nullable();
            $table->string('currency', 150)->nullable();
            $table->string('discount', 150)->nullable();
            $table->string('amountToCredit', 150)->nullable();
            $table->integer('status')->default(2);
            $table->string('checkoutType', 150)->nullable();
            $table->integer('completedOnWhatsapp')->default(2);
            $table->string('totalAmountToPay', 150)->nullable();
            $table->string('channelPaymentReference', 150)->nullable();
            $table->string('paymentReference', 150)->nullable();
            $table->string('channelPaymentId', 150)->nullable();
            $table->string('datePaid', 150)->nullable();
            $table->longText('paymentLog')->nullable();
            $table->integer('customerApproval')->default(2);
            $table->integer('merchantApproval')->default(2);
            $table->string('customerApprovalTime', 150)->nullable();
            $table->integer('merchantTimeApproved')->default(2);
            $table->integer('customerTimeApproval')->default(2);
            $table->integer('reported')->default(2);
            $table->text('supportDecision')->nullable();
            $table->string('settlementTime', 150)->nullable();
            $table->timestamps(, 150);
            $table->string('deleted_at', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_store_orders');
    }
}
