<?php

use App\Http\Controllers\Dashboard\Account;
use App\Http\Controllers\Mobile\Ads\Auth\Login;
use App\Http\Controllers\Mobile\Ads\Auth\RecoverPassword;
use App\Http\Controllers\Mobile\Ads\Auth\Register;
use App\Http\Controllers\Mobile\Ads\CatalogController;
use App\Http\Controllers\Mobile\Ads\MarketplaceController;
use App\Http\Controllers\Mobile\Ads\ReviewController;
use App\Http\Controllers\Mobile\Ads\SplashScreenController;
use App\Http\Controllers\Mobile\Ads\StoreController;
use App\Http\Controllers\Mobile\Home;
use App\Http\Controllers\Mobile\LegalController;
use App\Http\Controllers\Mobile\User\Ads\AdsDetails;
use App\Http\Controllers\Mobile\User\Ads\AdsEdit;
use App\Http\Controllers\Mobile\User\Ads\AdsIndex;
use App\Http\Controllers\Mobile\User\Events\Attendees;
use App\Http\Controllers\Mobile\User\Events\EventDetail;
use App\Http\Controllers\Mobile\User\Events\EventEdit;
use App\Http\Controllers\Mobile\User\Events\EventIndex;
use App\Http\Controllers\Mobile\User\Events\TicketEdit;
use App\Http\Controllers\Mobile\User\Events\TicketIndex;
use App\Http\Controllers\Mobile\User\Profile;
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
        Route::get('events/{slug?}',[CatalogController::class,'catalogsInStore'])
            ->name('marketplace.events.detail');


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




            //View Ticket
            Route::get('events/{event}/view-ticket',[EventDetail::class,'viewTicket'])
                ->name('events.view-ticket');

            //REVIEWS
            Route::get('reviews/index',[ReviewController::class,'landingPage'])
                ->name('reviews.index');
            Route::post('reviews/new/process',[ReviewController::class,'processNewRating'])
                ->name('reviews.new.process');

            //PROFILE PLACEHOLDERS
            Route::get('profile/coming-soon',[Profile::class,'comingSoon'])
                ->name('coming.soon');

            Route::get('profile/app/settings',[Profile::class,'settings'])
                ->name('app.settings');
            Route::get('profile/help',[Profile::class,'helpCenter'])
                ->name('help');
        });
    });
});
