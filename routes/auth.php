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
Route::get('login',[Login::class,'landingPage'])
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

    //Two-factor authentication
    Route::get('login/login-verification',[Login::class,'twoFactorAuthentication'])
        ->name('login-verification');
    Route::post('login/login-verification/process',[Login::class,'processTwoFactor'])
        ->name('auth.twoFactor');

    //Password Reset authentication
    Route::get('recover-password/email-verification',[RecoverPassword::class,'requestVerificationPage'])
        ->name('verify-password-reset');
    Route::post('recover-password/email-verification/process',[RecoverPassword::class,'processVerificationCode'])
        ->name('auth.recovery');

    Route::get('logout',[Login::class,'logout'])
        ->name('logout');

    //Complete Profile
    Route::get('complete-account-setup',[CompleteProfile::class,'landingPage'])
        ->name('complete-account-setup')->middleware('twoFactor');
    Route::post('complete-account-setup/process/tutor',[CompleteProfile::class,'processAccountCompletionTutor'])
        ->name('complete-account-setup.process.tutor');
    Route::post('complete-account-setup/process/school',[CompleteProfile::class,'processAccountCompletionSchool'])
        ->name('complete-account-setup.process.school');
    Route::post('complete-account-setup/process/parent',[CompleteProfile::class,'processAccountCompletionParent'])
        ->name('complete-account-setup.process.parent');

});
