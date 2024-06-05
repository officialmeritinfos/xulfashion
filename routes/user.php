<?php

use App\Http\Controllers\Dashboard\Account;
use App\Http\Controllers\Dashboard\Analytics;
use App\Http\Controllers\Dashboard\Home;
use App\Http\Controllers\Dashboard\User\AdController;
use App\Http\Controllers\Dashboard\User\Settings;
use App\Http\Controllers\Dashboard\User\Stores\StoreActions\CatalogController;
use App\Http\Controllers\Dashboard\User\Stores\StoreActions\Categories;
use App\Http\Controllers\Dashboard\User\Stores\StoreActions\Coupons;
use App\Http\Controllers\Dashboard\User\Stores\StoreActions\Customers;
use App\Http\Controllers\Dashboard\User\Stores\StoreActions\InvoiceController;
use App\Http\Controllers\Dashboard\User\Stores\StoreActions\KYB;
use App\Http\Controllers\Dashboard\User\Stores\StoreActions\NewsLetter;
use App\Http\Controllers\Dashboard\User\Stores\StoreActions\Orders;
use App\Http\Controllers\Dashboard\User\Stores\StoreActions\Teams;
use App\Http\Controllers\Dashboard\User\Stores\StoreActions\Themes;
use App\Http\Controllers\Dashboard\User\Stores\Stores;
use App\Http\Controllers\Dashboard\User\Stores\StoreActions\Settings as StoreSettings;
use Illuminate\Support\Facades\Route;

Route::middleware('completedProfile')->group(function (){
    Route::get('dashboard',[Home::class,'landingPage'])
        ->name('dashboard');//landing page

    Route::get('dashboard/activity',[Home::class,'userActivities'])
        ->name('dashboard.activity');//user activities
    Route::get('dashboard/activity/all',[Home::class,'allUserActivities'])
        ->name('dashboard.activity.all');//all activities
    Route::get('dashboard/activity/{id}/read',[Home::class,'readUserActivity'])
        ->name('dashboard.activity.read');//read an activity
    Route::get('dashboard/activity/read-all',[Home::class,'readAllUserActivity'])
        ->name('dashboard.activity.read.all');//read all activity

    //Analytics
    Route::get('analytics/country-data',[Analytics::class,'fetchCountryAnalyticsData'])
        ->name('country.analytics');
    Route::get('analytics/order-data',[Analytics::class,'fetchOrderData'])
        ->name('order.analytics');
    Route::get('analytics/customer-data',[Analytics::class,'fetchCustomerAnalytics'])
        ->name('customer.analytics');
    Route::get('analytics/online-offline-data',[Analytics::class,'onlineOfflineAnalytics'])
        ->name('customer.online.offline');

    /*========================= SETTINGS ==========================*/
    Route::get('settings/index',[Settings::class,'landingPage'])
        ->name('settings.index');
    Route::get('settings/verification',[Settings::class,'verification'])
        ->name('settings.verification');
    Route::get('settings/basic',[Settings::class,'basicSettings'])
        ->name('settings.basic');
    Route::get('settings/payout',[Settings::class,'payoutAccount'])
        ->name('settings.payout');
    Route::get('settings/security',[Settings::class,'securitySettings'])
        ->name('settings.security');
    Route::get('settings/cv',[Settings::class,'cvSetting'])
        ->name('settings.cv');
    Route::get('settings/portfolio',[Settings::class,'bioSetting'])
        ->name('settings.portfolio');

    //POST
    Route::post('settings/basic',[Settings::class,'updateBasicSettings'])
        ->name('settings.basic.update');//basic update
    Route::post('settings/security/password/update',[Settings::class,'updateSecuritySettingsPassword'])
        ->name('settings.security.password.update');//password change
    Route::post('settings/security/2fa/update',[Settings::class,'updateSecuritySettingsTwoFactor'])
        ->name('settings.security.2fa.update');//password change
    Route::post('settings/cv/update',[Settings::class,'updateCVSetting'])
        ->name('settings.cv.update');//update cv
    Route::post('settings/payout/add',[Settings::class,'addPayoutAccount'])
        ->name('settings.payout.add');//add payout account
    Route::post('settings/kyc/update',[Settings::class,'processKycSubmission'])
        ->name('settings.kyc.update');//complete kyc
    Route::post('settings/portfolio/update',[Settings::class,'processPortfolioUpdate'])
        ->name('settings.portfolio.update');//complete kyc

    //Misc
    Route::post('send/otp',[Settings::class,'sendOtp'])
        ->name('settings.send.otp');
    Route::post('fetch/banks',[Settings::class,'getCountryBanks'])
        ->name('settings.get.banks');

    /*========================= ACCOUNT BALANCE ==========================*/
    Route::get('account/index',[Account::class,'landingPage'])
        ->name('account.index');
    Route::post('account/convert-referral',[Account::class,'convertFromReferralToMain'])
        ->name('account.convert.referral');
    Route::post('account/fund',[Account::class,'fundAccount'])
        ->name('account.fund');
    Route::post('account/withdraw',[Account::class,'withdrawFromAccount'])
        ->name('account.withdraw');

    /*========================= ADS CONTROLLER ==========================*/
    Route::get('ads/index',[AdController::class,'landingPage'])
        ->name('ads.index');
    Route::get('ads/{id}/detail',[AdController::class,'adDetails'])
        ->name('ads.details');
    //GET
    Route::get('ads/new',[AdController::class,'newAdPage'])
        ->name('ads.new');
    Route::get('ads/{id}/edit',[AdController::class,'editAdPage'])
        ->name('ads.edit');
    Route::get('ads/{id}/delete',[AdController::class,'deleteAd'])
        ->name('ads.delete');
    Route::get('ads/photo/{ad}/{id}/delete',[AdController::class,'deleteAdPhoto'])
        ->name('ads.photo.delete');

    //POST
    Route::post('ads/new/process',[AdController::class,'processAdCreation'])
        ->name('ads.new.process');
    Route::post('ads/edit/{id}/process',[AdController::class,'processAdEdit'])
        ->name('ads.edit.process');
    Route::post('ads/photo/add/{id}/process',[AdController::class,'processAdPhotoUpload'])
        ->name('ads.photo.add.process');

    /*========================= STORES CONTROLLER ==========================*/
    Route::get('stores/index',[Stores::class,'landingPage'])
        ->name('stores.index');
    //GET
    Route::get('stores/new',[Stores::class,'initializeStore'])
        ->name('stores.new');
    Route::get('stores/edit/info',[Stores::class,'editStoreInfo'])
        ->name('stores.edit.info');//edit store info
    //POST
    Route::post('stores/initialize/process',[Stores::class,'processStoreInitialization'])
        ->name('stores.initialize.process');
    Route::post('stores/edit/{id}/process',[Stores::class,'processStoreEdit'])
        ->name('stores.edit.process');
    /*===============================STORE ACTIONS ===============================*/
    //KYB
    Route::get('stores/verify',[KYB::class,'verifyStore'])
        ->name('stores.verify');//store kyb
    Route::post('stores/kyc/process',[KYB::class,'processKybSubmission'])
        ->name('stores.kyc.process');
    //Settings
    Route::get('stores/edit/settings',[StoreSettings::class,'editStoreSettings'])
        ->name('stores.edit.settings');//edit store settings
    Route::post('stores/edit/settings/{id}/process',[StoreSettings::class,'processStoreSettingsEdit'])
        ->name('stores.edit.settings.process');
    //CATALOG
    Route::get('stores/catalog',[CatalogController::class,'landingPage'])
        ->name('stores.catalog');//store catalog
    //Product
    Route::get('stores/catalog/products',[CatalogController::class,'products'])
        ->name('stores.catalog.products');//store product catalog
    Route::get('stores/catalog/products/new',[CatalogController::class,'newProducts'])
        ->name('stores.catalog.products.new');//new store product catalog
    Route::post('stores/catalog/products/new/process',[CatalogController::class,'processNewProduct'])
        ->name('stores.catalog.products.new.process');//process new store product catalog
    Route::get('stores/catalog/product/{id}/edit-status',[CatalogController::class,'editProductStatus'])
        ->name('stores.catalog.product.edit.status');//edit store catalog product status
    Route::get('stores/catalog/product/{id}/delete',[CatalogController::class,'deleteProduct'])
        ->name('stores.catalog.product.delete');//delete store catalog product
    Route::get('stores/catalog/products/deleted',[CatalogController::class,'deletedProducts'])
        ->name('stores.catalog.products.deleted');//delete store product catalog
    Route::get('stores/catalog/product/{id}/restore',[CatalogController::class,'restoreProduct'])
        ->name('stores.catalog.product.restore');//restore deleted store catalog product
    Route::get('stores/catalog/product/{id}/p-delete',[CatalogController::class,'permanentlyDeleteProduct'])
        ->name('stores.catalog.product.p.delete');//permanently delete store catalog product
    Route::get('stores/catalog/product/{id}/edit',[CatalogController::class,'editProducts'])
        ->name('stores.catalog.product.edit');//edit store catalog product
    Route::post('stores/catalog/product/{id}/edit.process',[CatalogController::class,'processProductEdit'])
        ->name('stores.catalog.product.edit.process');//edit store catalog product
    Route::get('stores/catalog/product/{id}/edit-image',[CatalogController::class,'editProductsImages'])
        ->name('stores.catalog.product.edit.image');//edit store catalog product image
    Route::get('stores/catalog/product/{id}/edit-specs',[CatalogController::class,'editProductsSpecs'])
        ->name('stores.catalog.product.edit.specs');//edit store catalog product image
    Route::get('stores/catalog/product/{id}/highlight',[CatalogController::class,'highlightProduct'])
        ->name('stores.catalog.product.highlight');//highlight product
    Route::get('stores/catalog/product/{id}/remove/highlight',[CatalogController::class,'removeHighlightProduct'])
        ->name('stores.catalog.product.highlight.remove');//remove highlight product
    Route::get('stores/catalog/product/{id}/featured',[CatalogController::class,'markFeatured'])
        ->name('stores.catalog.product.featured');//feature product
    Route::get('stores/catalog/product/{id}/remove/featured',[CatalogController::class,'removeFeatured'])
        ->name('stores.catalog.product.featured.remove');//remove featured product

    Route::get('stores/catalog/product/{ref}/image/{id}/delete',[CatalogController::class,'deleteProductImage'])
        ->name('stores.catalog.product.image.delete');//delete store catalog product image
    Route::post('stores/catalog/product/{id}/image/new/process',[CatalogController::class,'processNewProductImage'])
        ->name('stores.catalog.product.image.new.process');//add store catalog product image


    Route::get('stores/catalog/product/{ref}/size/{id}/delete',[CatalogController::class,'deleteProductSize'])
        ->name('stores.catalog.product.size.delete');//delete store catalog product size
    Route::get('stores/catalog/product/{ref}/color/{id}/delete',[CatalogController::class,'deleteProductColor'])
        ->name('stores.catalog.product.color.delete');//delete store catalog product color
    Route::post('stores/catalog/product/{id}/variant/new/process',[CatalogController::class,'processNewProductVariant'])
        ->name('stores.catalog.product.variant.new.process');//add store catalog product image
    //Categories
    Route::get('stores/catalog/category',[Categories::class,'landingPage'])
        ->name('stores.catalog.category');//store catalog category
    Route::post('stores/catalog/category/new/process',[Categories::class,'processNewCategory'])
        ->name('stores.catalog.category.new.process');
    Route::get('stores/catalog/category/{id}/edit',[Categories::class,'editCategory'])
        ->name('stores.catalog.category.edit');//edit store catalog category
    Route::post('stores/catalog/category/{id}/edit/process',[Categories::class,'processCategoryEdit'])
        ->name('stores.catalog.category.edit.process');//process category edit
    Route::get('stores/catalog/category/{id}/delete',[Categories::class,'deleteCategory'])
        ->name('stores.catalog.category.delete');//delete store catalog category
    //Newsletter
    Route::get('stores/newsletter',[NewsLetter::class,'landingPage'])
        ->name('stores.newsletter');//store newsletter
    //Coupons
    Route::get('stores/coupons',[Coupons::class,'landingPage'])
        ->name('stores.coupons');//store coupons
    Route::get('stores/coupons/new',[Coupons::class,'addNew'])
        ->name('stores.coupons.new');//new store coupon landing page
    Route::post('stores/coupons/new/process',[Coupons::class,'processNewCoupon'])
        ->name('stores.coupons.new.process');//new store coupon process
    Route::get('stores/coupons/{id}/delete',[Coupons::class,'deleteCoupon'])
        ->name('stores.coupons.delete');//delete
    Route::get('stores/coupons/{id}/edit',[Coupons::class,'editCouponPage'])
        ->name('stores.coupons.edit');//edit coupon page
    Route::post('stores/coupons/edit/{id}/process',[Coupons::class,'processEditCoupon'])
        ->name('stores.coupons.edit.process');//edit store coupon process
    //Orders
    Route::get('stores/orders',[Orders::class,'landingPage'])
        ->name('stores.orders');//store orders
    Route::get('stores/orders/{id}/details',[Orders::class,'orderDetails'])
        ->name('stores.orders.details');//store orders details
    Route::post('stores/orders/paid/{id}/process',[Orders::class,'markPaid'])
        ->name('stores.orders.paid.process');//mark payment as paid
    Route::post('stores/orders/complete/{id}/process',[Orders::class,'completeOrder'])
        ->name('stores.orders.complete.process');//complete order
    Route::post('stores/orders/cancel/{id}/process',[Orders::class,'cancelOrder'])
        ->name('stores.orders.cancel.process');//complete order
    //Teams
    Route::get('stores/teams',[Teams::class,'landingPage'])
        ->name('stores.teams');//store teams
    //Customers
    Route::get('stores/customers',[Customers::class,'landingPage'])
        ->name('stores.customers');//store customers
    Route::get('stores/customers/export',[Customers::class,'exportSubscribers'])
        ->name('stores.customers.export');//export store customers who are subscribed to newsletter
    Route::get('stores/customers/{id}/detail',[Customers::class,'customerDetails'])
        ->name('stores.customers.detail');//store customers detail
    //Invoices
    Route::get('stores/invoices',[InvoiceController::class,'landingPage'])
        ->name('stores.invoices');//store invoices
    Route::post('stores/invoices/new/process',[InvoiceController::class,'processNewInvoice'])
        ->name('stores.invoice.new.process');//new store invoice process
    Route::get('stores/invoices/{id}/edit',[InvoiceController::class,'editInvoice'])
        ->name('stores.invoices.edit');//edit invoice page
    Route::post('stores/invoices/edit/{id}/process',[InvoiceController::class,'processEditInvoice'])
        ->name('stores.invoice.edit.process');//edit store invoice process
    Route::get('stores/invoices/{id}/details',[InvoiceController::class,'invoiceDetail'])
        ->name('stores.invoices.details');//view invoice page
    Route::post('stores/invoices/notify/{id}/process',[InvoiceController::class,'processNotifyPayer'])
        ->name('stores.invoice.notify.process');//edit store invoice process
    Route::get('stores/invoices/{id}/print',[InvoiceController::class,'printInvoice'])
        ->name('stores.invoices.print');//print invoice page
    Route::get('stores/invoices/mark-paid/{id}/process',[InvoiceController::class,'markInvoicePaymentStatus'])
        ->name('stores.invoice.paid.process');//mark invoice as paid
    //Themes
    Route::get('stores/themes',[Themes::class,'landingPage'])
        ->name('stores.themes');//store themes
    Route::post('stores/themes/{id}/activate',[Themes::class,'landingPage'])
        ->name('stores.theme.activate');//store themes
    Route::get('stores/themes/customize',[Themes::class,'customizeDesign'])
        ->name('stores.theme.customize');//store themes
    Route::post('stores/themes/customize/process',[Themes::class,'saveCustomization'])
        ->name('stores.theme.customize.process');//store themes

});
