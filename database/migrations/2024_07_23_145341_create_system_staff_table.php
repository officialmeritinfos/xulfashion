<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_staff', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 150)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('password', 200);
            $table->integer('setPin')->default(2);
            $table->string('accountPin', 150)->nullable();
            $table->string('lastLogin', 200)->nullable();
            $table->string('loginTime', 150)->nullable();
            $table->string('role', 200)->nullable();
            $table->integer('isAdmin')->default(2);
            $table->integer('twoFactor')->default(1);
            $table->integer('hasUpdatedPassword')->default(2);
            $table->string('photo', 150)->nullable();
            $table->integer('status')->default(1);
            $table->rememberToken();
            $table->timestamps(, 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_staff');
    }
}
