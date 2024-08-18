<?php

use App\Http\Controllers\Company\Home;
use Illuminate\Support\Facades\Route;

Route::get('/',[Home::class,'landingPage'])->name('index');
/*================================ COMPANY CONTROLLER ==============================*/
Route::get('about',[Home::class,'about'])
    ->name('about');
