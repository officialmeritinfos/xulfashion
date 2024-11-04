<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_services', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('user', 150);
            $table->string('reference', 150);
            $table->string('title', 225);
            $table->string('price', 100);
            $table->string('currency', 50);
            $table->longText('description');
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->string('deleted_at', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchant_services');
    }
}
