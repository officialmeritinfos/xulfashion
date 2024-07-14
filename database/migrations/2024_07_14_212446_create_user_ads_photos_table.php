<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAdsPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_ads_photos', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('ad', 100)->nullable();
            $table->string('photo', 200)->nullable();
            $table->string('photoId', 150)->nullable();
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
        Schema::dropIfExists('user_ads_photos');
    }
}
