<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemStaffActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_staff_actions', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('staff', 150);
            $table->string('action', 150);
            $table->string('user', 150)->nullable();
            $table->integer('isSuper')->default(2);
            $table->string('model', 150);
            $table->string('model_id', 150);
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
        Schema::dropIfExists('system_staff_actions');
    }
}
