<?php

use App\Http\Controllers\Staff\Auth\LoginController;
use App\Http\Controllers\Staff\Auth\TwoFactorController;
use Illuminate\Support\Facades\Route;

Route::domain('staff.localhost')->group(function () {
    //Staff authentication
    Route::get('/',[LoginController::class,'landingPage'])->name('login');//login
    Route::post('login/process',[LoginController::class,'processLogin'])->name('login.process');//process login
    Route::get('login/authenticate',[TwoFactorController::class,'landingPage'])->name('twoFactor');//two-factor authentication
    Route::post('login/authenticate/process',[TwoFactorController::class,'processAuthentication'])->name('twoFactor');//process two-factor authentication

    //Staff dashboard main

    Route::middleware(['staff.loggedIn'])->group(function () {   });
});
