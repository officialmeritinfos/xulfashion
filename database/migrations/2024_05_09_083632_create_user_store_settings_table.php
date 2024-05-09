<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_settings', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('store');
            $table->integer('allowWhatsappCheckout')->default(2);
            $table->integer('allowOnlineCheckout')->default(2);
            $table->integer('allowEscrowPayments')->default(2);
            $table->string('whatsappContact', 150)->nullable();
            $table->text('whatsappMessage')->nullable();
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
        Schema::dropIfExists('user_store_settings');
    }
}
