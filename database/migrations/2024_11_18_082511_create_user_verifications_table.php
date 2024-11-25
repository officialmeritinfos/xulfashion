<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_verifications', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('user', 150)->nullable();
            $table->string('reference', 150)->nullable();
            $table->string('docType', 150)->nullable();
            $table->string('frontImage', 150)->nullable();
            $table->string('backImage', 150)->nullable();
            $table->string('idNumber', 150)->nullable();
            $table->string('selfie', 150)->nullable();
            $table->string('utilityBill', 150)->nullable();
            $table->integer('status')->default(2);
            $table->string('approvedBy', 100)->nullable();
            $table->text('rejectReason')->nullable();
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
        Schema::dropIfExists('user_verifications');
    }
}
