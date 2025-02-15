<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreOrderBreakdownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_order_breakdowns', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('store', 150);
            $table->string('orderId', 150);
            $table->string('product', 150);
            $table->string('quantity', 150)->nullable();
            $table->string('sizeVariants', 150)->nullable();
            $table->string('colorVariant', 150)->nullable();
            $table->string('amount', 100)->default('0');
            $table->string('totalAmount', 100)->default('0');
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
        Schema::dropIfExists('user_store_order_breakdowns');
    }
}
