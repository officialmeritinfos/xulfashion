<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_products', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('store', 150);
            $table->string('name', 200);
            $table->string('reference', 150)->nullable();
            $table->text('description');
            $table->string('featuredImage', 200);
            $table->string('amount', 150);
            $table->string('currency', 150);
            $table->string('quantity', 100)->default('0');
            $table->mediumText('keyFeatures');
            $table->mediumText('specifications');
            $table->string('manufacturer', 200)->nullable();
            $table->string('brand', 200)->nullable();
            $table->mediumText('whatsInBox')->nullable();
            $table->string('category', 150)->nullable();
            $table->mediumText('returnPolicy')->nullable();
            $table->mediumText('refundPolicy')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('user_store_products');
    }
}
