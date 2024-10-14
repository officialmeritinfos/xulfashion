<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_tickets', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('store', 150);
            $table->string('reference', 150);
            $table->string('customer', 150);
            $table->text('subject');
            $table->text('content');
            $table->integer('escalated')->default(2);
            $table->integer('status')->default(2);
            $table->string('department', 150)->nullable();
            $table->string('systemDepartment', 150)->nullable();
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
        Schema::dropIfExists('user_store_tickets');
    }
}
