<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->string('reference');
            $table->string('currency');
            $table->string('amount');
            $table->string('amountCredit', 100)->nullable();
            $table->string('channel');
            $table->string('paymentReference')->nullable();
            $table->string('paymentDetails')->nullable();
            $table->string('wallet')->nullable();
            $table->integer('paymentStatus')->default(2);
            $table->integer('status')->default(2);
            $table->string('approvedBy', 100)->nullable();
            $table->string('timeUpdated', 100)->nullable();
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
        Schema::dropIfExists('user_withdrawals');
    }
}
