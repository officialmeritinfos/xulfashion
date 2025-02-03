<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_ads', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('user');
            $table->string('reference', 150);
            $table->string('title', 200);
            $table->mediumText('description');
            $table->string('shop', 150)->nullable();
            $table->string('companyName', 200)->nullable();
            $table->integer('priceType')->default(1);
            $table->string('currency', 100)->nullable();
            $table->string('amount', 150)->default('0');
            $table->string('serviceType', 100)->nullable();
            $table->enum('industry',['beauty','fashion'])->default('fashion');
            $table->integer('isPromoted')->default(2);
            $table->string('promotionEndTime', 150)->nullable();
            $table->string('country', 150)->nullable();
            $table->string('state', 150);
            $table->text('tags')->nullable();
            $table->string('promotionAmount', 150)->default('0');
            $table->integer('openToNegotiation')->default(2);
            $table->string('featuredImage', 200)->nullable();
            $table->integer('status')->default(2);
            $table->float('numberOfViews')->default(0);
            $table->timestamps();
            $table->integer('approvedBy')->nullable();
            $table->text('rejectReason')->nullable();
            $table->string('dateApproved', 150)->nullable();
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
        Schema::dropIfExists('user_ads');
    }
}
