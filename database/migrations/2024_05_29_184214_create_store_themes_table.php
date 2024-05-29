<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_themes', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('theme', 150)->nullable();
            $table->integer('isDefault')->default(2);
            $table->string('featuredImage', 200)->nullable();
            $table->string('videoPreview', 150)->nullable();
            $table->string('textFont', 150)->nullable();
            $table->string('textColor', 150)->nullable();
            $table->string('primaryColor', 150)->nullable();
            $table->string('location', 150)->nullable();
            $table->string('footerText', 200);
            $table->text('footerScript');
            $table->string('headerTextColor', 150)->nullable();
            $table->integer('tracking')->default(2);
            $table->integer('perkSection')->default(2);
            $table->longText('perkTitle')->nullable();
            $table->longText('perkContent')->nullable();
            $table->longText('perkIcon')->nullable();
            $table->text('workingDay');
            $table->integer('comingSoon')->default(2);
            $table->longText('customCSS')->nullable();
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
        Schema::dropIfExists('store_themes');
    }
}
