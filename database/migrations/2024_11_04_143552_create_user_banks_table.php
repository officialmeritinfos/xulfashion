<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_banks', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('user');
            $table->string('bank', 150);
            $table->string('bankName', 150)->nullable();
            $table->string('accountNumber', 150);
            $table->string('reference', 150);
            $table->string('benRef', 150)->nullable();
            $table->string('flutterRef', 150)->nullable();
            $table->string('accountName', 150);
            $table->integer('isPrimary')->default(2);
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('user_banks');
    }
}
