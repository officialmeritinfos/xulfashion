<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffEmailVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_email_verifications', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('staff', 150);
            $table->string('email', 150);
            $table->string('token', 150);
            $table->timestamps();
            $table->string('codeExpires', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_email_verifications');
    }
}
