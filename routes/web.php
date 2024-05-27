<?php

use App\Http\Controllers\Dashboard\Account;
use App\Http\Controllers\Marketplace\MarketplaceController;
use App\Http\Controllers\Marketplace\PageController;
use App\Http\Controllers\Marketplace\StoreController;
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

/*===============================ACCOUNT PROCESSING================================*/
Route::post('account/fund',[Account::class,'fundAccount'])
    ->name('account.fund');
Route::post('account/withdraw',[Account::class,'withdrawFromAccount'])
    ->name('account.withdraw');


/*================================ MARKETPLACE CONTROLLER ==============================*/
Route::get('/ads/{country?}',[MarketplaceController::class,'landingPage'])
    ->name('marketplace.index');
Route::get('/ads/{slug}/{id}/detail',[MarketplaceController::class,'adDetails'])
    ->name('marketplace.detail');
Route::get('/ads/{id}/merchant',[MarketplaceController::class,'merchantDetail'])
    ->name('marketplace.merchant');
Route::get('/ads/{id}/state',[MarketplaceController::class,'adsByState'])
    ->name('marketplace.state');
Route::get('/ads/{id}/service',[MarketplaceController::class,'adsByService'])
    ->name('marketplace.service');
Route::get('ads/filter/search',[MarketplaceController::class,'filterAds'])
    ->name('marketplace.search');

//Store
Route::get('ads/stores/list',[StoreController::class,'landingPage'])
    ->name('marketplace.stores');
Route::get('/ads/store/search',[StoreController::class,'filterStores'])
    ->name('marketplace.store.search');
//Other pages
Route::get('/ads/page/faqs',[PageController::class,'faq'])
    ->name('marketplace.faq');
Route::get('/ads/page/terms',[PageController::class,'terms'])
    ->name('marketplace.terms');
Route::get('/ads/page/privacy',[PageController::class,'privacy'])
    ->name('marketplace.privacy');
Route::get('/ads/page/aml',[PageController::class,'aml'])
    ->name('marketplace.aml');

/*================================ COMPANY CONTROLLER ==============================*/
Route::get('about',[PageController::class,'about'])
    ->name('company.about');
