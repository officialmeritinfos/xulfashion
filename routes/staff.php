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
        Route::get('users/{id}/kyc',[Users::class, 'kyc'])->name('users.kyc');//show kyc
        Route::get('users/{id}/kyc-submission',[Users::class, 'kycSubmission'])->name('users.kyc.submission');//new kyc

    });
});
