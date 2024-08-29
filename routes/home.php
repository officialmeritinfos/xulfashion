<?php

use App\Http\Controllers\Company\Home;
use App\Http\Controllers\LegalController;
use Illuminate\Support\Facades\Route;

Route::get('/',[Home::class,'landingPage'])->name('index');
/*================================ COMPANY CONTROLLER ==============================*/
Route::get('about',[Home::class,'about'])
    ->name('about');
/*================================ LEGAL CONTROLLER  ===============================*/
Route::get('legal',[LegalController::class,'landingPage'])
    ->name('legal');

Route::get('legal/privacy-policy',[LegalController::class,'generalPrivacy'])
    ->name('privacy-policy');
Route::get('legal/terms-and-conditions',[LegalController::class,'generalTerms'])
    ->name('terms-and-conditions');
Route::get('legal/aml',[LegalController::class,'amlPolicy'])
    ->name('aml');
Route::get('legal/acceptable-use-policy',[LegalController::class,'acceptableUsePolicy'])
    ->name('acceptable-use-policy');

Route::get('legal/business-terms',[LegalController::class,'merchantTerms'])
    ->name('business-terms');
Route::get('legal/business-privacy-policy',[LegalController::class,'merchantPrivacy'])
    ->name('business-privacy-policy');
Route::get('legal/customer-privacy-policy',[LegalController::class,'customerPrivacy'])
    ->name('customer-privacy-policy');
Route::get('legal/guest-privacy-policy',[LegalController::class,'guestPrivacy'])
    ->name('guest-privacy-policy');

