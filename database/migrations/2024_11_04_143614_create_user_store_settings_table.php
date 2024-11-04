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
            $table->integer('allowNotifications')->default(2);
            $table->integer('allowNewLetters')->default(2);
            $table->integer('allowSignups')->default(2);
            $table->integer('collectPhone')->default(2);
            $table->string('defaultBuyText', 150)->default('Buy Now');
            $table->integer('whatsappSupport')->default(2);
            $table->string('whatsappSupportNumber', 150)->nullable();
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
        Schema::dropIfExists('user_store_settings');
    }
}
