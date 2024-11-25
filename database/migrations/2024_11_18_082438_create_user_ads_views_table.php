<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAdsViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_ads_views', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('user', 150)->nullable();
            $table->string('ipAddress', 150)->nullable();
            $table->text('browser')->nullable();
            $table->string('ad', 150);
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
        Schema::dropIfExists('user_ads_views');
    }
}
