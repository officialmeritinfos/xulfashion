<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->bigInteger('user')->nullable();
            $table->integer('twoFactor')->default(2);
            $table->integer('emailNotification')->default(1);
            $table->integer('newsletters')->default(1);
            $table->integer('withdrawalNotification')->default(1);
            $table->integer('depositNotification')->default(1);
            $table->integer('collectPayment')->default(1);
            $table->integer('notifications')->default(1);
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
        Schema::dropIfExists('user_settings');
    }
}
