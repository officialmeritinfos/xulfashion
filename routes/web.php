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


/*==============================MERCHANT STORE =====================================*/
Route::domain('{subdomain}.localhost')->group(function () {
    //landing page
    Route::get('/', function (){
      echo  "Hello";
      return ;
    })->name('merchant.store');//landing page

    Route::get('/category/{id}', function (){
        echo  "Hello";
        return;
    })->name('merchant.store.category');//category page

    Route::get('/product/{id}/detail', function (){
        echo  "Hello";
        return;
    })->name('merchant.store.product.detail');//category page

    Route::get('/invoice/{id}/detail', function (){
        echo  "Hello";
        return;
    })->name('merchant.store.invoice.detail');//category page

});
