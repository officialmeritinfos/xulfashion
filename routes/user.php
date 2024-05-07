<?php

use App\Http\Controllers\Dashboard\Account;
use App\Http\Controllers\Dashboard\Home;
use App\Http\Controllers\Dashboard\User\AdController;
use App\Http\Controllers\Dashboard\User\Settings;
use Illuminate\Support\Facades\Route;

Route::middleware('completedProfile')->group(function (){
    Route::get('dashboard',[Home::class,'landingPage'])
        ->name('dashboard');//landing page

    /*========================= SETTINGS ==========================*/
    Route::get('settings/index',[Settings::class,'landingPage'])
        ->name('settings.index');
    Route::get('settings/verification',[Settings::class,'verification'])
        ->name('settings.verification');
    Route::get('settings/basic',[Settings::class,'basicSettings'])
        ->name('settings.basic');
    Route::get('settings/payout',[Settings::class,'payoutAccount'])
        ->name('settings.payout');
    Route::get('settings/security',[Settings::class,'securitySettings'])
        ->name('settings.security');
    Route::get('settings/cv',[Settings::class,'cvSetting'])
        ->name('settings.cv');
    Route::get('settings/portfolio',[Settings::class,'bioSetting'])
        ->name('settings.portfolio');

    //POST
    Route::post('settings/basic',[Settings::class,'updateBasicSettings'])
        ->name('settings.basic.update');//basic update
    Route::post('settings/security/password/update',[Settings::class,'updateSecuritySettingsPassword'])
        ->name('settings.security.password.update');//password change
    Route::post('settings/security/2fa/update',[Settings::class,'updateSecuritySettingsTwoFactor'])
        ->name('settings.security.2fa.update');//password change
    Route::post('settings/cv/update',[Settings::class,'updateCVSetting'])
        ->name('settings.cv.update');//update cv
    Route::post('settings/payout/add',[Settings::class,'addPayoutAccount'])
        ->name('settings.payout.add');//add payout account
    Route::post('settings/kyc/update',[Settings::class,'processKycSubmission'])
        ->name('settings.kyc.update');//complete kyc
    Route::post('settings/portfolio/update',[Settings::class,'processPortfolioUpdate'])
        ->name('settings.portfolio.update');//complete kyc

    //Misc
    Route::post('send/otp',[Settings::class,'sendOtp'])
        ->name('settings.send.otp');
    Route::post('fetch/banks',[Settings::class,'getCountryBanks'])
        ->name('settings.get.banks');

    /*========================= ACCOUNT BALANCE ==========================*/
    Route::get('account/index',[Account::class,'landingPage'])
        ->name('account.index');
    Route::post('account/convert-referral',[Account::class,'convertFromReferralToMain'])
        ->name('account.convert.referral');
    Route::post('account/fund',[Account::class,'fundAccount'])
        ->name('account.fund');
    Route::post('account/withdraw',[Account::class,'withdrawFromAccount'])
        ->name('account.withdraw');

    /*========================= ADS CONTROLLER ==========================*/
    Route::get('ads/index',[AdController::class,'landingPage'])
        ->name('ads.index');
    Route::get('ads/{id}/detail',[AdController::class,'adDetails'])
        ->name('ads.details');
    //GET
    Route::get('ads/new',[AdController::class,'newAdPage'])
        ->name('ads.new');
    Route::get('ads/{id}/edit',[AdController::class,'editAdPage'])
        ->name('ads.edit');
    Route::get('ads/{id}/delete',[AdController::class,'deleteAd'])
        ->name('ads.delete');

    //POST
    Route::post('ads/new/process',[AdController::class,'processAdCreation'])
        ->name('ads.new.process');

});
