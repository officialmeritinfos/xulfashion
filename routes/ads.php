<?php



use App\Http\Controllers\Marketplace\MarketplaceController;
use App\Http\Controllers\Marketplace\PageController;
use App\Http\Controllers\Marketplace\StoreController;
use Illuminate\Support\Facades\Route;


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



