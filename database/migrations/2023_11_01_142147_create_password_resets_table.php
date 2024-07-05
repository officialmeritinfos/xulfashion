<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('user', 200)->nullable();
            $table->string('codeExpire', 200)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
            $table->string('updated_at', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
};
