<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_events', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 150);
            $table->string('user', 150);
            $table->string('title', 225);
            $table->longText('description');
            $table->string('customUrl', 150)->nullable();
            $table->string('category', 150)->nullable();
            $table->integer('eventScheduleType')->default(1);
            $table->string('startDate', 150);
            $table->string('endDate', 150)->nullable();
            $table->string('eventTimeZone', 150)->nullable();
            $table->string('eventFrequency', 150);
            $table->string('startTime', 150)->nullable();
            $table->string('endTime', 150)->nullable();
            $table->string('recurrenceType', 150)->nullable();
            $table->string('recurrenceInterval', 150)->nullable();
            $table->string('recurrenceEndType', 150)->nullable();
            $table->string('recurrenceEndCount', 150)->nullable();
            $table->string('recurrenceEndDate', 150)->nullable();
            $table->text('location')->nullable();
            $table->text('locationTip')->nullable();
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
        Schema::dropIfExists('user_events');
    }
}
