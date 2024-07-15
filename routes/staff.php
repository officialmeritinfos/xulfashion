<?php

use App\Http\Controllers\Staff\Auth\LoginController;
use App\Http\Controllers\Staff\Auth\TwoFactorController;
use App\Http\Controllers\Staff\Dashboard\Home;
use App\Http\Controllers\Staff\Dashboard\Users;
use Illuminate\Support\Facades\Route;

Route::domain('staff.localhost')->group(function () {
    //Staff authentication
    Route::get('/',[LoginController::class,'landingPage'])->name('login');//login
    Route::post('login/process',[LoginController::class,'processLogin'])->name('login.process');//process login
    Route::get('login/authenticate',[TwoFactorController::class,'landingPage'])->name('twoFactor');//two-factor authentication
    Route::post('login/authenticate/process',[TwoFactorController::class,'processAuthentication'])->name('twoFactor.process');//process two-factor authentication

    //Staff dashboard main

    Route::middleware(['auth.staff','auth:staff'])->prefix('me')->group(function () {
        //Dashboard landing page
        Route::get('dashboard',[Home::class,'landingPage'])->name('dashboard');
        Route::get('dashboard/logout',[Home::class,'logout'])->name('logout');

        //User management page
        Route::get('users/list',[Users::class,'landingPage'])->name('users.list');
        Route::get('users/new',[Users::class,'create'])->name('users.new');
        Route::get('users/{id}/complete-profile',[Users::class, 'completeProfile'])->name('users.complete-profile');
        Route::get('users/{id}/detail',[Users::class, 'details'])->name('users.detail');
        //KYC
        Route::get('users/{id}/kyc',[Users::class, 'kyc'])->name('users.kyc');//show kyc
        Route::get('users/{id}/kyc-submission',[Users::class, 'kycSubmission'])->name('users.kyc.submission');//new kyc
        //Balance
        Route::get('users/{id}/balance',[Users::class, 'accountBalance'])->name('users.balance');//user balance
        Route::get('users/{merchant}/balance/{id}/payouts',[Users::class, 'withdrawalDetail'])->name('users.balance.payouts');//payout
        //Payout Account
        Route::get('users/{id}/payout-account',[Users::class, 'payoutAccount'])->name('users.payout-account');//payout accounts
        //Edit Merchant Information
        Route::get('users/{id}/bio/edit-info',[Users::class, 'editMerchantInfo'])->name('users.bio.edit-info');//update merchant information
        //Merchant listings
        Route::get('users/{id}/ads',[Users::class, 'merchantAds'])->name('users.ads');//merchant ads
        Route::get('users/{id}/ads/new',[Users::class, 'newMerchantAds'])->name('users.ads.new');//add merchant ads
        Route::get('users/{id}/ads/{ad}/details',[Users::class, 'merchantAdsDetail'])->name('users.ads.details');//view merchant ad




    });
});
