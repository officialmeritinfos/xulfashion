<?php

use App\Http\Controllers\Company\Home;
use Illuminate\Support\Facades\Route;

Route::get('/',[Home::class,'landingPage'])->name('index');
/*================================ COMPANY CONTROLLER ==============================*/
Route::get('about',[Home::class,'about'])
    ->name('about');
Route::get('privacy-policy',[Home::class,'about'])
    ->name('privacy-policy');
Route::get('terms-and-conditions',[Home::class,'about'])
    ->name('terms-and-conditions');

