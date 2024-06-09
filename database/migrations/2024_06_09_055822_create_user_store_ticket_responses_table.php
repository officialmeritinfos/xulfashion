<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreTicketResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_ticket_responses', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('customer', 150);
            $table->string('store', 150);
            $table->text('reply');
            $table->string('agent', 150)->nullable();
            $table->integer('storeAgent')->default(1);
            $table->integer('responder')->default(1);
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
        Schema::dropIfExists('user_store_ticket_responses');
    }
}
