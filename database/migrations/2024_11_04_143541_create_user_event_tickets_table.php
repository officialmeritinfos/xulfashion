<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEventTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_event_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->string('reference', 150)->nullable();
            $table->string('ticketType', 150);
            $table->string('name', 225);
            $table->text('description');
            $table->string('kindOfTicket', 100)->default('1');
            $table->integer('isGroup')->default(2);
            $table->string('currency', 150)->nullable();
            $table->string('price', 150)->default('0');
            $table->integer('isFree')->default(2);
            $table->integer('inviteOnly')->default(2);
            $table->string('quantity', 150)->default('0');
            $table->integer('unlimited')->default(2);
            $table->integer('allowBulkPurchase')->default(2);
            $table->string('bulkPrice', 150)->default('0');
            $table->string('bulkQuantity', 50)->nullable();
            $table->string('groupSize', 150)->nullable();
            $table->string('groupPrice', 150)->nullable();
            $table->longText('perks')->nullable();
            $table->longText('questions')->nullable();
            $table->string('ticketSold', 100)->default('0');
            $table->integer('purchaseLimit')->default(1);
            $table->integer('guestsShouldPayFee')->default(2);
            $table->integer('status')->default(1);
            $table->timestamps();
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
        Schema::dropIfExists('user_event_tickets');
    }
}
