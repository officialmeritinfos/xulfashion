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
            $table->string('eventType', 100)->nullable();
            $table->string('organizer', 150)->nullable();
            $table->string('title', 225);
            $table->longText('description');
            $table->string('platform', 150)->nullable();
            $table->text('link')->nullable();
            $table->integer('hideVenue')->default(2);
            $table->string('category', 150)->nullable();
            $table->integer('eventScheduleType')->default(1);
            $table->string('startDate', 150);
            $table->string('endDate', 150)->nullable();
            $table->string('eventTimeZone', 150)->nullable();
            $table->string('eventFrequency', 150)->nullable();
            $table->string('startTime', 150)->nullable();
            $table->string('endTime', 150)->nullable();
            $table->string('recurrenceInterval', 150)->nullable();
            $table->string('recurrenceEndType', 150)->nullable();
            $table->string('recurrenceEndCount', 150)->nullable();
            $table->string('recurrenceEndDate', 150)->nullable();
            $table->string('recurrenceEndTime', 150)->nullable();
            $table->string('state', 150)->nullable();
            $table->text('location')->nullable();
            $table->string('featuredImage', 200)->nullable();
            $table->string('currentRecurring', 100)->default('0');
            $table->string('facebook', 150)->nullable();
            $table->string('instagram', 150)->nullable();
            $table->string('twitter', 150)->nullable();
            $table->string('website', 150)->nullable();
            $table->string('totalSales', 250)->default('0');
            $table->string('currentBalance', 250)->default('0');
            $table->string('nextSettlement', 150)->nullable();
            $table->string('balanceCleared', 250)->default('0');
            $table->integer('status')->default(2);
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
