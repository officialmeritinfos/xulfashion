<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 150)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('address', 150)->nullable();
            $table->string('phone', 150)->nullable();
            $table->string('logo', 150)->nullable();
            $table->string('favicon', 150)->nullable();
            $table->string('codeExpire', 100)->default('30 minutes');
            $table->integer('emailVerification')->default(1);
            $table->text('description')->nullable();
            $table->string('keywords', 200)->nullable();
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
        Schema::dropIfExists('general_settings');
    }
}
