<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserVerificationDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_verification_document_types', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 150)->nullable();
            $table->string('slug', 150)->nullable();
            $table->string('country', 150)->nullable();
            $table->integer('hasBack')->default(2);
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
        Schema::dropIfExists('user_verification_document_types');
    }
}
