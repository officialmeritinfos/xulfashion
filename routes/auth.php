<?php


use App\Http\Controllers\Auth\CompleteProfile;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\RecoverPassword;
use App\Http\Controllers\Auth\Register;
use Illuminate\Support\Facades\Route;

/*========== ACCOUNT CREATION ======================*/
Route::get('register',[Register::class,'landingPage'])
    ->name('register');
Route::post('register/process',[Register::class,'processRegistration'])
    ->name('auth.register');

/*========== ACCOUNT LOGIN ======================*/
Route::get('mobile/app/login',[Login::class,'landingPage'])
    ->name('login');
Route::post('login/process',[Login::class,'processLogin'])
    ->name('auth.login');

/*========== ACCOUNT RECOVERY ======================*/
Route::get('recover-password',[RecoverPassword::class,'landingPage'])
    ->name('recoverPassword');
Route::post('recover-password/process',[RecoverPassword::class,'processPasswordRecovery'])
    ->name('auth.recover');

Route::middleware(['web','auth'])->group(function (){

    //Email verification
    Route::get('register/email-verification',[Register::class,'emailVerification'])
        ->name('email-verification');
    Route::post('register/email-verification/process',[Register::class,'processEmailVerification'])
        ->name('auth.email');
    Route::post('register/email-verification/resend',[Register::class,'resendVerificationMail'])
            ->name('auth.email.resend')->middleware(['throttle:token-resend']);

    //Two-factor authentication
    Route::get('login/login-verification',[Login::class,'twoFactorAuthentication'])
        ->name('login-verification');
    Route::post('login/login-verification/process',[Login::class,'processTwoFactor'])
        ->name('auth.twoFactor');
    Route::post('register/login-verification/resend',[Login::class,'resendVerificationMail'])
                ->name('auth.twoFactor.resend')->middleware(['throttle:token-resend']);

    //Password Reset authentication
    Route::get('recover-password/email-verification',[RecoverPassword::class,'requestVerificationPage'])
        ->name('verify-password-reset');
    Route::post('recover-password/email-verification/process',[RecoverPassword::class,'processVerificationCode'])
        ->name('auth.recovery');

    Route::get('logout',[Login::class,'logout'])
        ->name('logout');
    Route::get('logout/mobile',[Login::class,'mobileLogout'])
        ->name('logout.mobile');

    //Complete Profile
    Route::get('complete-account-setup',[CompleteProfile::class,'landingPage'])
        ->name('complete-account-setup')->middleware('twoFactor');
    Route::post('complete-account-setup/process/seller',[CompleteProfile::class,'processAccountCompletionSeller'])
        ->name('complete-account-setup.process.seller');
    Route::post('complete-account-setup/process/user',[CompleteProfile::class,'processAccountCompletionUser'])
        ->name('complete-account-setup.process.user');

});
