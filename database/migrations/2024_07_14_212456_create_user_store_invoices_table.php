<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_invoices', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('store', 150);
            $table->string('title', 150);
            $table->text('description');
            $table->string('customer', 150)->nullable();
            $table->string('currency', 150)->nullable();
            $table->string('amount', 150);
            $table->string('amountPaid', 150);
            $table->string('charge', 150)->default('0');
            $table->string('amountCredit', 150)->default('0');
            $table->string('reference', 150)->nullable();
            $table->string('paymentReference', 200)->nullable();
            $table->text('items')->nullable();
            $table->text('itemPrice')->nullable();
            $table->text('itemQuantity')->nullable();
            $table->text('terms')->nullable();
            $table->integer('status')->default(2);
            $table->integer('paymentStatus')->default(2);
            $table->string('channelPaymentReference', 150)->nullable();
            $table->string('channelPaymentId', 150)->nullable();
            $table->string('paymentMethod', 150)->nullable();
            $table->string('processorFee', 150)->default('0');
            $table->integer('customerApproval')->default(2);
            $table->integer('merchantApproval')->default(2);
            $table->string('customerApprovalTime', 150)->nullable();
            $table->string('merchantTimeApproved', 150)->nullable();
            $table->string('customerTimeApproval', 150)->nullable();
            $table->integer('reported')->default(2);
            $table->text('supportDecision')->nullable();
            $table->string('settlementTime', 150)->nullable();
            $table->string('datePaid', 150)->nullable();
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
        Schema::dropIfExists('user_store_invoices');
    }
}
