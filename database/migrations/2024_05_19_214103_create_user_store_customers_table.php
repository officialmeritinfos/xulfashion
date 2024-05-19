<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_customers', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->integer('store');
            $table->string('reference', 150);
            $table->string('email', 200)->nullable();
            $table->string('name', 200)->nullable();
            $table->string('phone', 150)->nullable();
            $table->text('bio')->nullable();
            $table->string('password', 200)->nullable();
            $table->string('country', 150)->nullable();
            $table->string('state', 150)->nullable();
            $table->string('city', 150)->nullable();
            $table->text('address')->nullable();
            $table->string('subscribedToNewletter', 150)->nullable();
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
        Schema::dropIfExists('user_store_customers');
    }
}
