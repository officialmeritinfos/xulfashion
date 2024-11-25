<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreThemeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_theme_settings', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('store', 150);
            $table->string('textFont', 150)->nullable();
            $table->string('textColor', 150)->nullable();
            $table->string('primaryColor', 150)->nullable();
            $table->string('footerText', 200)->nullable();
            $table->text('footerScript')->nullable();
            $table->string('headerTextColor', 150)->nullable();
            $table->integer('tracking')->default(2);
            $table->integer('perkSection')->default(2);
            $table->text('perkTitle')->nullable();
            $table->longText('customCSS')->nullable();
            $table->text('perkContent')->nullable();
            $table->string('perkIcon', 150)->nullable();
            $table->text('workingDay')->nullable();
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
        Schema::dropIfExists('user_store_theme_settings');
    }
}
