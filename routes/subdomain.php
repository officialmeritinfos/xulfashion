<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Storefront\CartController;
use App\Http\Controllers\Storefront\CatalogController;
use App\Http\Controllers\Storefront\CheckoutController;
use App\Http\Controllers\Storefront\Home;
use App\Http\Controllers\Storefront\InvoiceController;
use App\Http\Controllers\Storefront\ProductController;
use App\Http\Controllers\Storefront\User\Dashboard;
use App\Http\Controllers\Storefront\User\Login;
use App\Http\Controllers\Storefront\User\Orders;
use App\Http\Controllers\Storefront\User\Profiles;
use App\Http\Controllers\Storefront\User\TicketController;

/*==============================MERCHANT STORE =====================================*/

Route::domain('{subdomain}.localhost')->group(function () {
    Route::middleware(['applyTheme','extend.session'])->group(function (){
        //landing page
        Route::get('/', [Home::class,'landingPage'])->name('merchant.store');//landing page
        Route::get('about', [Home::class,'aboutPage'])->name('merchant.about');//about page
        Route::get('contact', [Home::class,'contactPage'])->name('merchant.contact');//contact page
        Route::get('refund-policy', [Home::class,'refundPolicy'])->name('merchant.refund');//refund policy page
        Route::get('return-policy', [Home::class,'returnPolicy'])->name('merchant.return');//return policy page
        Route::get('country/fetch-state/{id}',[Home::class,'fetchCountryStates'])->name('fetch.country.state');

        Route::get('/category/{id}', [CatalogController::class,'category'])
            ->name('merchant.store.category');//category page

        Route::get('/product/{id}/detail', [ProductController::class,'productDetail'])
            ->name('merchant.store.product.detail');//product page
        Route::get('/product/{id}/reviews', [ProductController::class,'getProductReviews'])
            ->name('merchant.store.product.reviews');//product reviews

        //Invoice
        Route::get('/invoice/{id}/detail',[InvoiceController::class,'landingPage'])
            ->name('merchant.store.invoice.detail');//invoice page
        Route::post('/invoice/{id}/pay',[InvoiceController::class,'makePayment'])
            ->name('merchant.store.invoice.pay');//make payment for invoice
        Route::get('invoice/payment/{id}/process',[InvoiceController::class,'processInvoiceOrderPayment'])
            ->name('merchant.store.invoice.payment.process');//callback for processing payment

        Route::get('/shop', [CatalogController::class,'shop'])->name('merchant.store.shop');//shop page
        Route::get('shop/search', [CatalogController::class,'shopSearchPage'])->name('merchant.store.shop.search');//shop search page
        Route::get('/catalog', [CatalogController::class,'catalog'])->name('merchant.store.catalog');//catalog page

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
        Route::post('checkout/order/process/authenticated',[CheckoutController::class,'processCheckoutAuthenticated'])
            ->name('merchant.store.checkout.process.authenticated')->middleware('auth.customer');


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

        /**=========================STORE USER ACCOUNT ===============================================*/
        //Dashboard overview
        Route::get('user/login',[Login::class,'landingPage'])
            ->name('merchant.store.login');//login
        Route::get('user/register',[Login::class,'landingPage'])
            ->name('merchant.store.register');//register
        Route::get('user/recover-password',[Login::class,'landingPage'])
            ->name('merchant.store.recoverPassword');//recover password

        //POST
        Route::post('user/login/process',[Login::class,'processLogin'])
            ->name('merchant.store.login.process');//login
        Route::get('user/login/{customer}/authenticate',[Login::class,'authenticateLogin'])
            ->name('merchant.store.login.authenticate');//authenticate login from mail


        Route::middleware(['customer.login','auth.customer'])->group(function (){
            //Dashboard overview
            Route::get('user/index',[Dashboard::class,'landingPage'])
                ->name('merchant.store.user.index');
            Route::get('user/logout',[Dashboard::class,'logout'])
                ->name('merchant.store.user.logout');
            //Orders
            Route::get('user/orders',[Orders::class,'landingPage'])
                ->name('merchant.store.user.orders');
            //Orders
            Route::get('user/profile',[Profiles::class,'landingPage'])
                ->name('merchant.store.user.profile');
            //Settings
            Route::get('user/settings',[Profiles::class,'settings'])
                ->name('merchant.store.user.settings');
            Route::post('user/settings/{customer}/process',[Profiles::class,'updateInfoSettings'])
                ->name('merchant.store.settings.process');//process settings
            Route::post('user/settings/{customer}/process-password-setup',[Profiles::class,'setupPassword'])
                ->name('merchant.store.settings.process.password.setup');//process password setup
            Route::post('user/settings/{customer}/process-password',[Profiles::class,'changePassword'])
                ->name('merchant.store.settings.process.password');//process password setup
        });

        //Store support Ticket
        Route::get('ticket/index',[TicketController::class,'landingPage'])
            ->name('merchant.store.ticket.index');
        Route::get('ticket/new',[TicketController::class,'newTicket'])
            ->name('merchant.store.ticket.new');
    });
});
