<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_coupons', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('store');
            $table->string('reference', 150)->nullable();
            $table->string('code', 150)->nullable();
            $table->integer('couponType')->default(1);
            $table->string('currency', 50)->nullable();
            $table->string('discount', 150);
            $table->integer('generatedBy')->nullable();
            $table->integer('limitedByUse')->default(2);
            $table->string('useLimit', 150)->nullable();
            $table->string('numberOfUsage', 150)->default('0');
            $table->string('deactivateByDate', 150)->default('2');
            $table->string('usageDeadline', 150)->nullable();
            $table->integer('status')->default(1);
            $table->string('deleted_at', 150)->nullable();
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
        Schema::dropIfExists('user_store_coupons');
    }
}
