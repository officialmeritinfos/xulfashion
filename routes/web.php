<?php

use App\Http\Controllers\Dashboard\Account;
use App\Http\Controllers\Mobile\Ads\Auth\Login;
use App\Http\Controllers\Mobile\Ads\Auth\RecoverPassword;
use App\Http\Controllers\Mobile\Ads\Auth\Register;
use App\Http\Controllers\Mobile\Ads\CatalogController;
use App\Http\Controllers\Mobile\Ads\EventCartController;
use App\Http\Controllers\Mobile\Ads\EventCheckoutController;
use App\Http\Controllers\Mobile\Ads\EventCheckoutPaymentController;
use App\Http\Controllers\Mobile\Ads\EventController;
use App\Http\Controllers\Mobile\Ads\MarketplaceController;
use App\Http\Controllers\Mobile\Ads\SplashScreenController;
use App\Http\Controllers\Mobile\Ads\StoreController;
use App\Http\Controllers\Mobile\Ads\TicketController;
use App\Http\Controllers\Mobile\CountryController;
use App\Http\Controllers\Mobile\Home;
use App\Http\Controllers\Mobile\LegalController;
use App\Http\Controllers\Mobile\User\Ads\AdsDetails;
use App\Http\Controllers\Mobile\User\Ads\AdsEdit;
use App\Http\Controllers\Mobile\User\Ads\AdsIndex;
use App\Http\Controllers\Mobile\User\Events\Attendees;
use App\Http\Controllers\Mobile\User\Events\BuyerPurchaseController;
use App\Http\Controllers\Mobile\User\Events\EventDetail;
use App\Http\Controllers\Mobile\User\Events\EventEdit;
use App\Http\Controllers\Mobile\User\Events\EventIndex;
use App\Http\Controllers\Mobile\User\Events\MerchantPurchaseController;
use App\Http\Controllers\Mobile\User\Events\TicketEdit;
use App\Http\Controllers\Mobile\User\Events\TicketIndex;
use App\Http\Controllers\Mobile\User\Payments\BankFetchingController;
use App\Http\Controllers\Mobile\User\Payments\PaymentController;
use App\Http\Controllers\Mobile\User\Payments\SettlementAccountController;
use App\Http\Controllers\Mobile\User\Payments\SettlementAccountProcessorController;
use App\Http\Controllers\Mobile\User\Profile;
use App\Http\Controllers\Mobile\User\Reviews\ReviewController;
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

Route::get('/manifest-marketplace.json', function() {
    return response()->view('manifest.manifest-marketplace')->header('Content-Type', 'application/json');
})->name('manifest-marketplace');

Route::get('/manifest/offline-client', function() {
    return response()->view('manifest.offline-client');
})->name('manifest-offline.client');
Route::get('/manifest/offline-business', function() {
    return response()->view('manifest.offline-business');
})->name('manifest-offline.business');

Route::any('push-notification/store/token',[Home::class,'registerToken'])->name('push.store');
Route::get('push-notification/store/test',[Home::class,'push'])->name('push.test');

//Country controller
Route::get('get-states', [CountryController::class, 'getStatesByCountry'])->name('get.states');
Route::get('get-states-event', [CountryController::class, 'fetchStates'])->name('get.states.event');

/* ================================MOBILE WEB PWA ROUTE ===========================*/

Route::prefix('mobile')->name('mobile.')->group(function (){

    Route::get('index',[Home::class,'landingPage'])->name('index');
    Route::get('base',[Home::class,'base'])->name('base');

    //mobile page for ads
    Route::get('/ads/base',[SplashScreenController::class,'landingPage'])
        ->name('ads.index');//splash screen
    Route::prefix('app')->group(function (){
        Route::get('base',[SplashScreenController::class,'appStartingPage'])
            ->name('app.base');//splash screen
        Route::get('/ads/categories',[MarketplaceController::class,'categories'])
            ->name('marketplace.categories');

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

        //STORES
        Route::get('stores/list',[StoreController::class,'landingPage'])
            ->name('marketplace.stores');
        Route::get('stores/{id}/detail',[StoreController::class,'storeDetail'])
            ->name('marketplace.store.detail');

        Route::get('/store/search',[StoreController::class,'searchSuggestion'])
            ->name('marketplace.store.search');
        Route::get('/store/category/search',[StoreController::class,'categorySearchResult'])
            ->name('marketplace.store.category.search');
        Route::get('/store/search/result',[StoreController::class,'searchResult'])
            ->name('marketplace.store.search.result');

        //CATALOG
        Route::get('stores/{id}/catalog',[CatalogController::class,'catalogsInStore'])
            ->name('marketplace.catalog.index');
        Route::get('stores/{store}/catalog/{catalog}/detail',[CatalogController::class,'catalogItems'])
            ->name('marketplace.catalog.detail');
        Route::get('stores/{store}/product/{product}/detail',[CatalogController::class,'productDetail'])
            ->name('marketplace.store.product.detail');

        //EVENTS
        Route::get('events',[EventController::class,'landingPage'])
            ->name('marketplace.events');
        Route::get('events/{slug?}',[EventController::class,'eventDetail'])
            ->name('marketplace.events.detail');
        Route::get('events/{id}/tickets',[EventController::class,'eventTickets'])
            ->name('marketplace.events.tickets');
        //EVENT CART
        Route::post('events/ticket/cart-manager',[EventCartController::class,'updateCart'])
            ->name('marketplace.events.cart.manager');
        Route::get('events/ticket/cart-total',[EventCartController::class,'getCartTotal'])
            ->name('marketplace.events.cart.total');
        Route::get('events/ticket/cart-delete',[EventCartController::class,'deleteCart'])
            ->name('marketplace.events.cart.delete');
        Route::get('events/ticket/cart-list',[EventCartController::class,'renderCartList'])
            ->name('marketplace.events.cart.list');
        Route::get('events/ticket/cart-merge',[EventCartController::class,'mergeGuestCart'])
            ->name('marketplace.events.cart.merge');
        //EVENT CHECKOUT
        Route::middleware(['web','auth','auth.session','lockedOut','twoFactor'])->group(function(){
            //Checkout Group - must be authenticated first.
            Route::get('events/ticket/{event}/show-checkout',[EventCheckoutController::class,'checkoutLandingPage'])
                ->name('marketplace.events.cart.show-checkout');
            Route::post('events/ticket/{event}/process-checkout',[EventCheckoutController::class,'processCheckout'])
                ->name('marketplace.events.cart.process.checkout');

            //process payment redirect and verify
            Route::get('events/ticket/{event}/{payment}/process-checkout-payment',[EventCheckoutPaymentController::class,'processCheckSuccessfulPayment'])
                ->name('marketplace.events.cart.process.checkout.payment');
            //process payment redirect and cancel
            Route::get('events/ticket/{event}/{payment}/process-checkout-payment-cancel',[EventCheckoutPaymentController::class,'processCheckoutCancelledPayment'])
                ->name('marketplace.events.cart.process.checkout.payment.cancel');
            //Check Payment Status
            Route::get('events/ticket/purchase/checkout/{purchaseRef}/{transactionId}/payment-status',[EventCheckoutPaymentController::class,'checkStatus'])
                ->name('marketplace.events.ticket.purchase.checkout.payment.status');
        });



        //LEGAL PAGE
        Route::get('legal/privacy-policy',[LegalController::class,'privacyPolicy'])->name('legal.privacy-policy');
        Route::get('legal/delete-my-information',[LegalController::class,'deleteMyInformation'])->name('legal.delete-my-information');



        //Registration & Login as User
        //REGISTRATION
        Route::get('register',[Register::class,'landingPage'])->name('register');
        Route::post('register/process',[Register::class,'processRegistration'])
            ->name('register.process');
        //LOGIN
        Route::get('login',[Login::class,'landingPage'])->name('login');
        Route::post('login/process',[Login::class,'processLogin'])->name('login.process');
        //FORGOTTEN PASSWORD
        Route::get('recover-password',[RecoverPassword::class,'landingPage'])
            ->name('recoverPassword');
        Route::post('recover-password/process',[RecoverPassword::class,'processPasswordRecovery'])
            ->name('recover.process');


        Route::middleware(['web','auth'])->group(function () {
            //Email verification
            Route::get('register/email-verification', [Register::class, 'emailVerification'])
                ->name('email-verification');
            Route::post('register/email-verification/process', [Register::class, 'processEmailVerification'])
                ->name('auth.email');
            Route::post('register/email-verification/resend', [Register::class, 'resendVerificationMail'])
                ->name('auth.email.resend')->middleware(['throttle:token-resend']);

            //Two-factor authentication
            Route::get('login/login-verification', [Login::class, 'twoFactorAuthentication'])
                ->name('login-verification');
            Route::post('login/login-verification/process', [Login::class, 'processTwoFactor'])
                ->name('auth.twoFactor');
            Route::post('register/login-verification/resend', [Login::class, 'resendVerificationMail'])
                ->name('auth.twoFactor.resend')->middleware(['throttle:token-resend']);

            //Password Reset authentication
            Route::get('recover-password/email-verification',[RecoverPassword::class,'requestVerificationPage'])
                ->name('verify-password-reset');
            Route::post('recover-password/email-verification/process',[RecoverPassword::class,'processVerificationCode'])
                ->name('auth.recovery');
            Route::post('recover/recovery-verification/resend', [RecoverPassword::class, 'resendVerificationMail'])
                ->name('auth.passwordRecover.resend')->middleware(['throttle:token-resend']);

        });
        //USER ACCOUNT ROUTE MOBILE
        Route::middleware(['web','auth','lockedOut','twoFactor'])->name('user.')->prefix('user')->group(function () {
            //profile
            Route::get('profile',[Profile::class,'landingPage'])
                ->name('profile.landing-page');
            Route::get('profile/edit',[Profile::class,'editProfile'])
                ->name('profile.edit');
            Route::post('profile/edit/process',[Profile::class,'updateProfile'])
                ->name('profile.edit.process');
            Route::get('profile/settings/complete-profile',[Profile::class,'completeProfile'])
                ->name('profile.settings.complete-profile');
            Route::post('profile/settings/complete-profile/process',[Profile::class,'processCompleteProfile'])
                ->name('profile.settings.complete-profile.process');

            /*====================ADS DIRECTORY ===========================*/
            Route::get('ads/index',[AdsIndex::class,'landingPage'])
                ->name('ads.index');
            //Post Ads
            Route::get('ads/new',[AdsIndex::class,'createAd'])
                ->name('ads.new');
            Route::post('ads/new/process',[AdsIndex::class,'processNewAd'])
                ->name('ads.new.process');
            //ADS DETAILS
            Route::get('ads/{id}/detail',[AdsDetails::class,'landingPage'])
                ->name('ads.detail');
            Route::get('ads/{id}/photo/{photo}/delete',[AdsDetails::class,'deletePhoto'])
                ->name('ads.photo.delete');
            //Ads Edit
            Route::get('ads/{id}/edit',[AdsEdit::class,'landingPage'])
                ->name('ads.edit');
            Route::post('ads/edit/process',[AdsEdit::class,'processAdUpdate'])
                ->name('ads.edit.process');

            /*====================EVENT DIRECTORY ===========================*/
            Route::get('events/index',[EventIndex::class,'landingPage'])
                ->name('events.index');
            //Manage Event - Buyer Dashboard
            Route::get('events/purchase/{purchase}/detail',[BuyerPurchaseController::class,'purchaseDetail'])
                ->name('events.purchase.detail');
            //Guest Management
            Route::get('events/purchase/{purchase}/{purchaseTicket}/add-guests',[BuyerPurchaseController::class,'addGuest'])
                ->name('events.purchase.add-guests');
            Route::post('events/purchase/{purchase}/{purchaseTicket}/process-add-guests',[BuyerPurchaseController::class,'processGuestAddition'])
                ->name('events.purchase.add-guests.process');
            //Send Ticket to Guest
            Route::post('events/purchase/{purchase}/{purchaseTicket}/{guestId}/send-ticket',[BuyerPurchaseController::class,'sendMailToGuest'])
                ->name('events.purchase.guest.send-ticket');
            //View and Download ticket
            Route::get('event/{event}/ticket/{ticket}/guest/{guest}/view-ticket',[TicketController::class,'displayTicket'])
                ->name('event.purchase.guest.ticket.view');
            Route::get('event/{event}/ticket/{ticket}/general/view-ticket',[TicketController::class,'displayTicketGeneral'])
                ->name('event.purchase.guest.ticket.view.general');


            //Manage Event - Organizer Dashboard
            Route::get('events/manage',[EventIndex::class,'manageEvent'])
                ->name('events.manage');
            //Create Event
            Route::get('events/new/online',[EventIndex::class,'createOnlineEvent'])
                ->name('events.new.online');
            Route::get('events/new/live',[EventIndex::class,'createLiveEvent'])
                ->name('events.new.live');
            Route::post('events/new/live/process',[EventIndex::class,'processLiveEventCreation'])
                ->name('events.new.live.process');
            Route::post('events/new/online/process',[EventIndex::class,'processOnlineEventCreation'])
                ->name('events.new.online.process');
            //Event Detail
            Route::get('events/{event}/detail',[EventDetail::class,'landingPage'])
                ->name('events.detail');
            Route::get('events/{event}/sales',[EventDetail::class,'sales'])
                ->name('events.sales');
            Route::get('events/tickets/{event}/email',[EventDetail::class,'eventEmail'])
                ->name('events.tickets.email');
            Route::post('events/tickets/{event}/email/process',[EventDetail::class,'processEmail'])
                ->name('events.tickets.email.process');
            //Event Purchase Detail
            Route::get('events/{event}/sales/{purchase}/purchase-detail',[MerchantPurchaseController::class,'purchaseDetail'])
                ->name('events.sales.purchase-detail');

            //Event Edit
            Route::get('events/{event}/edit',[EventEdit::class,'landingPage'])
                ->name('events.edit');
            Route::post('events/edit/live/process',[EventEdit::class,'processLiveEventUpdate'])
                ->name('events.edit.live.process');
            Route::post('events/edit/online/process',[EventEdit::class,'processOnlineEventUpdate'])
                ->name('events.edit.online.process');
            //Ticket Index
            Route::get('events/tickets/{event}/index',[TicketIndex::class,'landingPage'])
                ->name('events.tickets.index');
            //Create ticket
            Route::get('events/tickets/{event}/new',[TicketIndex::class,'createTicket'])
                ->name('events.tickets.new');
            Route::post('events/ticket/single/{event}/process',[TicketIndex::class,'processSingleTicketCreation'])
                ->name('events.ticket.single.process');
            Route::post('events/ticket/group/{event}/process',[TicketIndex::class,'processGroupTicketCreation'])
                ->name('events.ticket.group.process');
            //Delete Ticket
            Route::post('events/ticket/{event}/delete',[TicketIndex::class,'deleteTicket'])
                ->name('events.ticket.delete');
            //Edit Ticket
            Route::get('events/tickets/{ticket}/edit',[TicketEdit::class,'landingPage'])
                ->name('events.tickets.edit');
            Route::post('events/tickets/{event}/{ticket}/edit/single/process',[TicketEdit::class,'processSingleTicketUpdate'])
                ->name('events.tickets.edit.single.process');
            Route::post('events/tickets/{event}/{ticket}/edit/group/process',[TicketEdit::class,'processGroupTicketUpdate'])
                ->name('events.tickets.edit.group.process');

            //Event Attendees
            Route::get('events/{event}/attendees',[Attendees::class,'landingPage'])
                ->name('events.attendees');
            Route::get('events/{event}/attendees/check-in-list',[Attendees::class,'checkInList'])
                ->name('events.attendees.check-in-list');
            Route::get('events/{event}/attendees/notify',[Attendees::class,'notifyAttendees'])
                ->name('events.attendees.notify');
            Route::post('events/{event}/attendees/notify/process',[Attendees::class,'processAttendeeNotification'])
                ->name('events.attendees.notify.process');
            //Event Attendees action
            Route::post('events/{event}/attendees/{guest}/checkin',[Attendees::class,'checkInGuest'])
                ->name('events.attendees.checkin');//check-in guest
            Route::get('events/{event}/attendees/search', [Attendees::class, 'searchGuests'])
                ->name('events.attendees.search');//search attendees
            Route::get('events/{event}/attendees/checkin/search', [Attendees::class, 'searchCheckedInGuests'])
                ->name('events.attendees.checkin.search');//search attendees


            //View Ticket
            Route::get('events/{event}/view-ticket',[EventDetail::class,'viewTicket'])
                ->name('events.view-ticket');

            //REVIEWS
            Route::get('reviews/index',[ReviewController::class,'landingPage'])
                ->name('reviews.index');
            Route::post('reviews/new/process',[ReviewController::class,'processNewRating'])
                ->name('reviews.new.process');
            Route::get('reviews/{review}/detail',[ReviewController::class,'reviewDetail'])
                ->name('reviews.detail');
            Route::post('reviews/{review}/reply/process',[ReviewController::class,'processReviewResponse'])
                ->name('reviews.reply.process');

            //PAYMENTS FOLDER ROUTE
            Route::get('payments/index',[PaymentController::class,'landingPage'])->name('payments.index');
            Route::get('payments/merchant/index',[PaymentController::class,'merchantDashboard'])->name('payments.merchant.index');
            //Settlement accounts
            Route::get('settlement/account/index',[SettlementAccountController::class,'landingPage'])->name('settlement.account.index');
            //Process settlement accounts
            Route::post('settlement/account/local-account/process',[SettlementAccountProcessorController::class,'processLocalSettlementAccount'])
                ->name('settlement.account.local-account.process');




            //Bank fetching controller
            Route::get('payments/payout-method/fetch-bank-by-country/{country?}',[BankFetchingController::class,'fetchBanksByCountry'])
                ->name('payments.payout-method.fetch-bank-by-country');
            Route::get('payments/payout-method/fetch-bank-branch-code/{bankId?}',[BankFetchingController::class,'fetchBankBranchCode'])
                ->name('payments.payout-method.fetch-bank-branch-code');
            Route::get('payments/payout-method/fetch-account-detail/{bankCode?}/{accountNumber?}',[BankFetchingController::class,'retrieveAccountDetail'])
                ->name('payments.payout-method.fetch-account-detail');
            Route::post('payments/payout-method/send-otp',[BankFetchingController::class,'sendOTP'])->name('payments.payout-method.send-otp');
            Route::post('payments/payout-method/verify-otp',[BankFetchingController::class,'verifyOTP'])->name('payments.payout-method.verify-otp');



            //PROFILE PLACEHOLDERS
            Route::get('profile/coming-soon',[Profile::class,'comingSoon'])
                ->name('coming.soon');
            Route::get('profile/app/settings',[Profile::class,'settings'])
                ->name('app.settings');
            Route::get('profile/help',[Profile::class,'helpCenter'])
                ->name('help');
        });

        //EVENT TICKET DOWNLOAD
        Route::get('event/{event}/ticket/{ticket}/guest/{guest}/download',[TicketController::class,'displayTicket'])
            ->name('event.ticket.guest.download')->middleware('signed');
        Route::get('event/{event}/{guest}/download-ics',[TicketController::class,'generateICSFile'])
            ->name('event.download-ics');

    });
});
