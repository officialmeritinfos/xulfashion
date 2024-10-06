<?php

use App\Http\Controllers\Dashboard\Account;
use App\Http\Controllers\Mobile\Ads\Auth\Login;
use App\Http\Controllers\Mobile\Ads\Auth\RecoverPassword;
use App\Http\Controllers\Mobile\Ads\Auth\Register;
use App\Http\Controllers\Mobile\Ads\CatalogController;
use App\Http\Controllers\Mobile\Ads\MarketplaceController;
use App\Http\Controllers\Mobile\Ads\SplashScreenController;
use App\Http\Controllers\Mobile\Ads\StoreController;
use App\Http\Controllers\Mobile\Home;
use App\Http\Controllers\Mobile\LegalController;
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


            //PROFILE PLACEHOLDERS
            //coming soon
            Route::get('profile/coming-soon',[Profile::class,'comingSoon'])
                ->name('coming.soon');
            Route::get('profile/post-ads',[Profile::class,'postAds'])
                ->name('post.ads');
            Route::get('profile/settings',[Profile::class,'settings'])
                ->name('app.settings');
            Route::get('profile/help',[Profile::class,'helpCenter'])
                ->name('help');
        });
    });
});
