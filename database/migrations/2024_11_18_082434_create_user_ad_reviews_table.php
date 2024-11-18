<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAdReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_ad_reviews', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('reviewer', 150);
            $table->string('merchant', 150);
            $table->string('reference', 150);
            $table->text('comment');
            $table->string('rating', 150);
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('user_ad_reviews');
    }
}
