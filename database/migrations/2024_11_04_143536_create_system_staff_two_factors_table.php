<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemStaffTwoFactorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_staff_two_factors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user');
            $table->string('email');
            $table->string('token');
            $table->string('codeExpire');
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
        Schema::dropIfExists('system_staff_two_factors');
    }
}
