<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreNewslettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_newsletters', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('store', 150);
            $table->string('subject', 200);
            $table->longText('content');
            $table->text('receipients');
            $table->string('timeToSend', 150)->nullable();
            $table->timestamps(, 150);
            $table->string('deleted_at', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_store_newsletters');
    }
}
