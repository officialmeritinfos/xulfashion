<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payout_currencies', function (Blueprint $table) {
            $table->id();
            $table->string('currency')->unique();
            $table->boolean('requires_account_bank')->default(false);
            $table->boolean('requires_account_number')->default(false);
            $table->boolean('is_bank')->default(true);
            $table->boolean('is_mobile_money')->default(false);
            $table->boolean('is_international')->default(false);
            $table->boolean('requires_destination_branch_code')->default(false);
            $table->json('meta')->nullable();
            $table->mediumText('mobile_money_providers')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout_currencies');
    }
};
