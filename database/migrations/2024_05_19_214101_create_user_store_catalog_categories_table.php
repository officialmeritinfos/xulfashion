<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreCatalogCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_catalog_categories', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('store');
            $table->string('categoryName', 150);
            $table->integer('isDefault')->default(2);
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
        Schema::dropIfExists('user_store_catalog_categories');
    }
}
