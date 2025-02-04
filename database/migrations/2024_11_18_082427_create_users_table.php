<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique('users_email_unique');
            $table->string('reference', 150)->nullable();
            $table->string('username', 150)->nullable();
            $table->string('displayName', 150)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('accountType', 100)->nullable();
            $table->integer('merchantType')->nullable();
            $table->string('accountBalance', 150)->default('0');
            $table->string('referralBalance', 100)->default('0');
            $table->string('pendingBalance', 150)->default('0');
            $table->string('pendingBalanceStore', 150)->default('0');
            $table->string('mainCurrency', 150)->nullable();
            $table->string('country', 150)->nullable();
            $table->string('countryCode', 150)->nullable();
            $table->string('phone', 150)->nullable();
            $table->integer('isVerified')->default(2);
            $table->integer('loggedIn')->default(2);
            $table->string('referral', 100)->nullable();
            $table->integer('status')->default(1);
            $table->rememberToken();
            $table->string('registrationIp', 100)->nullable();
            $table->integer('completedProfile')->default(2);
            $table->string('gender', 100)->nullable();
            $table->string('dob', 100)->nullable();
            $table->string('heardAboutUs', 150)->nullable();
            $table->mediumText('bio')->nullable();
            $table->string('tutorKeywords', 200)->nullable();
            $table->string('photo', 200)->nullable();
            $table->text('address')->nullable();
            $table->string('google_id')->nullable();
            $table->string('companyName', 200)->nullable();
            $table->string('state', 150)->nullable();
            $table->integer('activateProfile')->default(1);
            $table->string('otp', 150)->nullable();
            $table->string('otpExpires', 150)->nullable();
            $table->integer('isAdmin')->default(2);
            $table->string('activelyLookingForJob', 100)->default('2');
            $table->string('supportToken', 150)->nullable();
            $table->integer('welcomeSent')->default(2);
            $table->string('tokenExpire', 100)->nullable();
            $table->integer('accountManager')->nullable();
            $table->integer('requestedForAccountDeletion')->default(2);
            $table->string('timeToDeleteAccount', 150)->nullable();
            $table->text('reasonForDeleting')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('users');
    }
}
