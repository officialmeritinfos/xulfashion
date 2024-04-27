<?php

use App\Http\Controllers\Dashboard\Account;
use App\Http\Controllers\Dashboard\Home;
use App\Http\Controllers\Dashboard\Tutor\Applications;
use App\Http\Controllers\Dashboard\Tutor\Jobs;
use App\Http\Controllers\Dashboard\Tutor\Payments;
use App\Http\Controllers\Dashboard\Tutor\Portfolios;
use App\Http\Controllers\Dashboard\Tutor\Settings;
use App\Http\Controllers\Dashboard\Tutor\Transactions;
use Illuminate\Support\Facades\Route;

Route::middleware('completedProfile')->group(function (){
    Route::get('dashboard',[Home::class,'landingPage'])
        ->name('dashboard');//landing page

    /*========================= APPLICATIONS ==========================*/
    Route::get('applications/index',[Applications::class,'landingPage'])
        ->name('applications.index');
    Route::get('applications/active',[Applications::class,'active'])
        ->name('applications.active');
    Route::get('applications/interviewing',[Applications::class,'interviewing'])
        ->name('applications.interviewing');
    Route::get('applications/closed',[Applications::class,'closed'])
        ->name('applications.closed');
    Route::get('applications/{id}/detail',[Applications::class,'applicationDetail'])
        ->name('applications.detail');
    /*========================= JOBS ==========================*/
    Route::get('jobs/index',[Jobs::class,'landingPage'])
        ->name('jobs.index');
    Route::get('jobs/index/search',[Jobs::class,'searchJob'])
        ->name('jobs.search');//search job by parameters
    Route::get('jobs/{id}/detail',[Jobs::class,'jobDetails'])
        ->name('jobs.detail');
    Route::post('job/{id}/apply',[Jobs::class,'applyForJob'])
        ->name('job.id.apply');

    Route::get('jobs/employments',[Jobs::class,'employments'])
        ->name('jobs.employments');
    Route::get('jobs/employment/{id}/detail',[Jobs::class,'employmentDetails'])
        ->name('jobs.employment.detail');

    /*========================= PAYMENTS ==========================*/
    Route::get('payments/index',[Payments::class,'landingPage'])
        ->name('payments.index');

    /*========================= PORTFOLIOS ==========================*/
    Route::get('portfolios/index',[Portfolios::class,'landingPage'])
        ->name('portfolios.index');
    //Experiences
    Route::post('portfolios/experience/add',[Portfolios::class,'addExperience'])
        ->name('portfolios.experience.add');
    Route::post('portfolios/experience/edit',[Portfolios::class,'updateExperience'])
        ->name('portfolios.experience.edit');
    Route::post('portfolios/experience/delete',[Portfolios::class,'deleteExperiences'])
        ->name('portfolios.experience.delete');
    Route::post('portfolios/experience/truncate',[Portfolios::class,'truncateExperiences'])
        ->name('portfolios.experience.truncate');
    //Skills
    Route::post('portfolios/skills/add',[Portfolios::class,'addSkills'])
        ->name('portfolios.skills.add');
    Route::post('portfolios/skills/delete',[Portfolios::class,'deleteSkills'])
        ->name('portfolios.skills.delete');
    Route::post('portfolios/skills/truncate',[Portfolios::class,'truncateSkills'])
        ->name('portfolios.skills.truncate');
    //Certifications
    Route::post('portfolios/certifications/add',[Portfolios::class,'addCertification'])
        ->name('portfolios.certifications.add');
    Route::post('portfolios/certifications/delete',[Portfolios::class,'deleteCertification'])
        ->name('portfolios.certifications.delete');
    Route::post('portfolios/certifications/truncate',[Portfolios::class,'truncateCertifications'])
        ->name('portfolios.certifications.truncate');
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


    /*========================= TRANSACTIONS ==========================*/
    Route::get('transactions/index',[Transactions::class,'landingPage'])
        ->name('transactions.index');

    /*========================= TUTOR ACCOUNT BALANCE ==========================*/
    Route::get('account/index',[Account::class,'landingPage'])
        ->name('account.index');
    Route::post('account/convert-referral',[Account::class,'convertFromReferralToMain'])
        ->name('account.convert.referral');
    Route::post('account/fund',[Account::class,'fundAccount'])
        ->name('account.fund');
    Route::post('account/withdraw',[Account::class,'withdrawFromAccount'])
        ->name('account.withdraw');

});
