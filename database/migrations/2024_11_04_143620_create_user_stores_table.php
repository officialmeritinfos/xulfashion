<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_stores', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('user');
            $table->string('name', 200)->nullable();
            $table->string('reference', 150)->nullable();
            $table->mediumText('description')->nullable();
            $table->string('currency', 150)->nullable();
            $table->integer('service')->nullable();
            $table->string('slug', 150)->nullable();
            $table->integer('isVerified')->default(2);
            $table->string('logo', 200)->nullable();
            $table->string('country', 150)->nullable();
            $table->string('state', 150)->nullable();
            $table->string('city', 150)->nullable();
            $table->text('address')->nullable();
            $table->string('phone', 150)->nullable();
            $table->string('phone2', 150)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('legalName', 200)->nullable();
            $table->mediumText('returnPolicy')->nullable();
            $table->mediumText('refundPolicy')->nullable();
            $table->string('numberOfViews', 100)->default('0');
            $table->string('theme', 150)->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
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
        Schema::dropIfExists('user_stores');
    }
}
