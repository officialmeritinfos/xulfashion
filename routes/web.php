<?php

use App\Http\Controllers\Dashboard\Account;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


/*===============================ACCOUNT PROCESSING================================*/
Route::post('account/fund',[Account::class,'fundAccount'])
    ->name('account.fund');
Route::post('account/withdraw',[Account::class,'withdrawFromAccount'])
    ->name('account.withdraw');




