<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreProductSizeVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_product_size_variations', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('product', 100);
            $table->string('name', 150);
            $table->timestamps(, 150);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_store_product_size_variations');
    }
}
