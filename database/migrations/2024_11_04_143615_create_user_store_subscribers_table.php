<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_subscribers', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('store');
            $table->string('reference', 150);
            $table->string('email', 150)->nullable();
            $table->integer('status')->default(2);
            $table->text('verificationCode')->nullable();
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
        Schema::dropIfExists('user_store_subscribers');
    }
}
