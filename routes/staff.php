<?php

use App\Http\Controllers\Staff\Auth\LoginController;
use App\Http\Controllers\Staff\Auth\TwoFactorController;
use App\Http\Controllers\Staff\Dashboard\ActivityController;
use App\Http\Controllers\Staff\Dashboard\AdController;
use App\Http\Controllers\Staff\Dashboard\Home;
use App\Http\Controllers\Staff\Dashboard\OrderController;
use App\Http\Controllers\Staff\Dashboard\SettingController;
use App\Http\Controllers\Staff\Dashboard\StaffController;
use App\Http\Controllers\Staff\Dashboard\StoreController;
use App\Http\Controllers\Staff\Dashboard\Users;
use Illuminate\Support\Facades\Route;

Route::domain('staff.xulstore.com')->group(function () {
    //Staff authentication
    Route::get('/',[LoginController::class,'landingPage'])->name('login');//login
    Route::post('login/process',[LoginController::class,'processLogin'])->name('login.process');//process login
    Route::get('login/authenticate',[TwoFactorController::class,'landingPage'])->name('twoFactor');//two-factor authentication
    Route::post('login/authenticate/process',[TwoFactorController::class,'processAuthentication'])->name('twoFactor.process');//process two-factor authentication
    Route::get('login/{token}/welcome/{email}/{staff}/set-password',[LoginController::class,'setupPassword'])->name('staff.setup.password');

    //Staff dashboard main

    Route::middleware(['auth.staff','auth:staff'])->prefix('me')->group(function () {
        //Dashboard landing page
        Route::get('dashboard',[Home::class,'landingPage'])->name('dashboard');
        Route::get('dashboard/logout',[Home::class,'logout'])->name('logout');

        //User management page
        Route::get('users/list',[Users::class,'landingPage'])->name('users.list');
        Route::get('users/new',[Users::class,'create'])->name('users.new');
        Route::get('users/{id}/complete-profile',[Users::class, 'completeProfile'])->name('users.complete-profile');
        Route::get('users/{id?}/detail',[Users::class, 'details'])->name('users.detail');
        //KYC
        Route::get('users/{id}/kyc',[Users::class, 'kyc'])->name('users.kyc');//show kyc
        Route::get('users/{id}/kyc-submission',[Users::class, 'kycSubmission'])->name('users.kyc.submission');//new kyc
        //Balance
        Route::get('users/{id}/balance',[Users::class, 'accountBalance'])->name('users.balance');//user balance
        Route::get('users/{merchant}/balance/{id}/payouts',[Users::class, 'withdrawalDetail'])->name('users.balance.payouts');//payout
        //Payout Account
        Route::get('users/{id}/payout-account',[Users::class, 'payoutAccount'])->name('users.payout-account');//payout accounts
        //Edit Merchant Information
        Route::get('users/{id}/bio/edit-info',[Users::class, 'editMerchantInfo'])->name('users.bio.edit-info');//update merchant information
        //Merchant listings
        Route::get('users/{id}/ads',[Users::class, 'merchantAds'])->name('users.ads');//merchant ads
        Route::get('users/{id}/ads/new',[Users::class, 'newMerchantAds'])->name('users.ads.new');//add merchant ads
        Route::get('users/{id}/ads/{ad}/details',[Users::class, 'merchantAdsDetail'])->name('users.ads.details');//view merchant ad
        //Merchant Store
        Route::get('users/{id}/store',[Users::class, 'merchantStore'])->name('users.store');//merchant store
        //Merchant activities
        Route::get('users/{id}/activities',[Users::class, 'merchantActivity'])->name('users.activities');//merchant activities
        //Merchant settings
        Route::get('users/{id}/settings',[Users::class, 'merchantSettings'])->name('users.settings');//merchant settings
        //Stores list
        Route::get('stores/list',[StoreController::class, 'landingPage'])->name('stores.list');
        Route::get('stores/{id}/coupons',[StoreController::class, 'coupons'])->name('stores.coupons');//coupons
        Route::get('stores/{id}/customers',[StoreController::class, 'customers'])->name('stores.customers');//customers
        Route::get('stores/{id}/customer/{ref}/detail',[StoreController::class, 'customerDetail'])->name('stores.customers.detail');//customer details
        Route::get('stores/{id}/invoices',[StoreController::class, 'invoices'])->name('stores.invoices');//invoices
        Route::get('stores/{id}/invoices/{ref}/detail',[StoreController::class, 'invoicesDetail'])->name('stores.invoices.detail');//invoice detail
        Route::get('stores/{id}/categories',[StoreController::class, 'categories'])->name('stores.categories');//Categories
        Route::get('stores/{id}/products',[StoreController::class, 'products'])->name('stores.products');//Products
        Route::get('stores/{id}/orders',[StoreController::class, 'orders'])->name('stores.orders');//Orders
        Route::get('stores/{id}/settings',[StoreController::class, 'settings'])->name('stores.settings');//Settings
        Route::get('stores/{id}/kyb',[StoreController::class, 'kyb'])->name('stores.kyb');//Store KYB
        //Orders
        Route::get('orders/list',[OrderController::class, 'landingPage'])->name('orders.list');
        Route::get('orders/{id}/{store}/detail',[OrderController::class, 'orderDetail'])->name('orders.detail');
        //Ads
        Route::get('ads/list',[AdController::class, 'landingPage'])->name('ads.list');
        //Activities
        Route::get('activity/index',[ActivityController::class, 'landingPage'])->name('activity.index');
        //Settings
        Route::get('settings/profile',[SettingController::class, 'profilePage'])->name('settings.profile');
        Route::get('settings/general',[SettingController::class, 'generalSettings'])->name('settings.general');
        Route::get('settings/security',[SettingController::class, 'securitySetting'])->name('settings.security');
        //Staff
        Route::get('staffs/list',[StaffController::class,'landingPage'])->name('staffs.list');
        Route::get('staffs/new',[StaffController::class,'addStaff'])->name('staffs.new');
        //Roles & Permissions
        Route::get('roles',[StaffController::class,'roles'])->name('roles');
        Route::get('permissions',[StaffController::class,'permissions'])->name('permissions');
    });
});
