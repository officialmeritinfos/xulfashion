<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_verifications', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('store');
            $table->string('reference', 150);
            $table->string('certificate', 200);
            $table->string('dba', 200)->nullable();
            $table->string('legalName', 200);
            $table->string('regNumber', 150);
            $table->string('addressProof', 200);
            $table->text('address');
            $table->integer('status');
            $table->text('rejectReason')->nullable();
            $table->string('approvedBy', 150)->nullable();
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
        Schema::dropIfExists('user_store_verifications');
    }
}
