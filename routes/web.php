<?php

use App\Http\Controllers\Dashboard\Account;
use App\Http\Controllers\Marketplace\MarketplaceController;
use App\Http\Controllers\Marketplace\PageController;
use App\Http\Controllers\Marketplace\StoreController;
use App\Http\Controllers\Storefront\CartController;
use App\Http\Controllers\Storefront\CheckoutController;
use App\Http\Controllers\Storefront\Home;
use App\Http\Controllers\Storefront\InvoiceController;
use App\Http\Controllers\Storefront\ProductController;
use App\Http\Controllers\Storefront\TicketController;
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
    Route::middleware(['applyTheme','extend.session'])->group(function (){
        //landing page
        Route::get('/', [Home::class,'landingPage'])->name('merchant.store');//landing page
        Route::get('country/fetch-state/{id}',[Home::class,'fetchCountryStates'])->name('fetch.country.state');

        Route::get('/category/{id}', [])->name('merchant.store.category');//category page

        Route::get('/product/{id}/detail', [])->name('merchant.store.product.detail');//product page

        //Invoice
        Route::get('/invoice/{id}/detail',[InvoiceController::class,'landingPage'])
            ->name('merchant.store.invoice.detail');//invoice page
        Route::post('/invoice/{id}/pay',[InvoiceController::class,'makePayment'])
            ->name('merchant.store.invoice.pay');//make payment for invoice
        Route::get('invoice/payment/{id}/process',[InvoiceController::class,'processInvoiceOrderPayment'])
            ->name('merchant.store.invoice.payment.process');//callback for processing payment

        Route::get('/shop', [])->name('merchant.store.shop');//shop page
        Route::get('/catalog', [])->name('merchant.store.catalog');//catalog page

        Route::get('product/{id}/quick-view',[ProductController::class,'quickView'])
            ->name('merchant.store.product.quick-view');

        Route::post('product/{id}/add-cart',[ProductController::class,'addToCart'])
            ->name('merchant.store.add.cart');//add to cart
        Route::post('product/remove-cart',[ProductController::class,'removeFromCart'])
            ->name('merchant.store.remove.cart');//remove from cart
        Route::post('product/update-cart',[ProductController::class,'updateCart'])
            ->name('merchant.store.update.cart');//update cart

        Route::get('product/cart-preview',[ProductController::class,'getCartItems'])
            ->name('merchant.store.cart.items');//preview cart items
        Route::post('product/remove-carts/{product}/{size}/{color}',[ProductController::class,'removeFromCart'])
            ->name('merchant.store.remove.carts');//remove from cart
        Route::get('get-cart-item-count', [ProductController::class,'getCartItemCount'])
            ->name('get.cart.item.count');
        //Checkout page
        Route::get('checkout', [CheckoutController::class,'landingPage'])
            ->name('merchant.store.checkout');
        Route::get('checkout/checkout-preview/summary',[CheckoutController::class,'getCartSummary'])
            ->name('merchant.store.checkout.summary.checkout');//preview cart items on cart page
        Route::post('checkout/order/process',[CheckoutController::class,'processCheckout'])
            ->name('merchant.store.checkout.process');


        Route::get('checkout/checkout-order/{id}/invoice',[CheckoutController::class,'checkoutInvoice'])
            ->name('merchant.store.checkout.order.invoice');//checkout invoice
        Route::post('checkout/order/{id}/make/payment',[CheckoutController::class,'makePaymentForOrder'])
            ->name('merchant.store.checkout.make.payment');
        //cart page
        Route::get('cart', [CartController::class,'cart'])->name('merchant.store.cart');
        Route::get('cart/cart-preview/cart',[CartController::class,'getCartItemCarts'])
            ->name('merchant.store.cart.items.cart');//preview cart items on cart page
        Route::get('cart/cart-preview/summary',[CartController::class,'getCartSummary'])
            ->name('merchant.store.cart.summary.cart');//preview cart items on cart page
        Route::post('cart/apply-coupon',[CartController::class,'addCoupon'])
            ->name('merchant.store.add.coupon');//add coupon
        Route::post('cart/remove-coupon',[CartController::class,'removeCoupon'])
            ->name('merchant.store.remove.coupon');//add coupon

        //Order Payment processing
        Route::get('checkout/checkout-order/payment/{id}/process',[CheckoutController::class,'processCheckoutOrderPayment'])
            ->name('merchant.store.checkout.order.payment.process');//callback for processing payment

        //Store support Ticket
        Route::get('ticket/new',[TicketController::class,'landingPage'])
            ->name('merchant.store.ticket.new');

    });
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



