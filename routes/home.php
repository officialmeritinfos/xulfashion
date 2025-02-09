<?php

use App\Http\Controllers\Company\BusinessesController;
use App\Http\Controllers\Company\Home;
use App\Http\Controllers\Company\LegalController;
use App\Http\Controllers\Company\SolutionsController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/',[Home::class,'landingPage'])->name('index');
/*================================ COMPANY CONTROLLER ==============================*/
Route::get('company/about',[Home::class,'about'])->name('about');
Route::get('company/contact',[Home::class,'contact'])->name('contact');
Route::get('company/career',[Home::class,'career'])->name('career');
Route::get('company/team',[Home::class,'team'])->name('team');
/*================================ MISCELLANEOUS HOME CONTROLLER ==============================*/
Route::get('pricing',[Home::class,'pricing'])->name('pricing');
Route::get('download-page',[Home::class,'download'])->name('download');
Route::get('download',[Home::class,'download'])->name('download.main');
Route::get('download-ios',[Home::class,'downloadIos'])->name('download.ios');
/*================================ SOLUTIONS CONTROLLER ==============================*/
Route::get('solutions/sell-online',[SolutionsController::class,'sellOnline'])->name('solutions.sell-online');
Route::get('solutions/invoice',[SolutionsController::class,'invoiceManagement'])->name('solutions.invoice');
Route::get('solutions/inventory',[SolutionsController::class,'inventory'])->name('solutions.inventory');
Route::get('solutions/pos',[SolutionsController::class,'pointOfSale'])->name('solutions.pos');
Route::get('solutions/payments',[SolutionsController::class,'payments'])->name('solutions.payments');
Route::get('solutions/booking',[SolutionsController::class,'bookingSolution'])->name('solutions.booking');
Route::get('solutions/listing',[SolutionsController::class,'businessListing'])->name('solutions.listing');
Route::get('solutions/events',[SolutionsController::class,'eventManagement'])->name('solutions.events');
Route::get('solutions/academy',[SolutionsController::class,'academy'])->name('solutions.academy');
/*================================ BUSINESSES CONTROLLER ==============================*/
Route::get('business/fashion-designer',[BusinessesController::class,'fashionDesigners'])->name('business.fashion-designer');
Route::get('business/beauty-entrepreneurs',[BusinessesController::class,'beautyEntrepreneur'])->name('business.beauty-entrepreneurs');
Route::get('business/fashion-schools',[BusinessesController::class,'fashionSchool'])->name('business.fashion-schools');
Route::get('business/manufacturers',[BusinessesController::class,'manufacturers'])->name('business.manufacturers');
Route::get('business/retailers',[BusinessesController::class,'retailers'])->name('business.retailers');

/*================================ RESOURCES CONTROLLER ==============================*/
Route::get('resources/faq',[Home::class,'faq'])->name('faq');

//Download marketplace apk
Route::get('download-page/marketplace',[Home::class,'downloadMarketplaceApp'])
    ->name('download-page.marketplace');


/*================================ LEGAL CONTROLLER  ===============================*/
Route::get('legal',[LegalController::class,'landingPage'])
    ->name('legal');

Route::get('legal/privacy-policy',[LegalController::class,'generalPrivacy'])
    ->name('privacy-policy');
Route::get('legal/terms-and-conditions',[LegalController::class,'generalTerms'])
    ->name('terms-and-conditions');
Route::get('legal/ads-posting-policy',[LegalController::class,'adsPolicy'])
    ->name('ads-posting-policy');
Route::get('legal/aml',[LegalController::class,'amlPolicy'])
    ->name('aml');
Route::get('legal/acceptable-use-policy',[LegalController::class,'acceptableUsePolicy'])
    ->name('acceptable-use-policy');

Route::get('legal/business-terms',[LegalController::class,'merchantTerms'])
    ->name('business-terms');
Route::get('legal/business-privacy-policy',[LegalController::class,'merchantPrivacy'])
    ->name('business-privacy-policy');
Route::get('legal/customer-privacy-policy',[LegalController::class,'customerPrivacy'])
    ->name('customer-privacy-policy');
Route::get('legal/guest-privacy-policy',[LegalController::class,'guestPrivacy'])
    ->name('guest-privacy-policy');

Route::get('delete-my-information',[LegalController::class,'deleteMyInformation'])
    ->name('delete-my-information');


//ACCOUNT REMOVAL PROCESSING
Route::get('verify-account-deletion/{email}/{id}',function (Request $request,$email,$id){
    if (! $request->hasValidSignature()) {
        abort(401);
    }

    $user = User::where(['email' => $email,'reference' => $id])->first();
    if (empty($user)){
        abort(404);
    }

    if ($user->requestedForAccountDeletion==1){
        return to_route('home.delete-my-information')->with('error','Account removal request already received.');
    }
    $message = "
        The user <b>".$user->name."</b> with ID ".$user->reference." has requested for their data to be deleted. This must be processed in 30 days if the user
        does not cancel their request.
    ";
    \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AccountDeletionReceived($user));
    sendDepartmentMail('compliance',$message,'New Account Deletion Request');
    $user->requestedForAccountDeletion=1;
    $user->timeToDeleteAccount = strtotime('30 Days',time());
    $user->save();

    echo "Account will be deleted after 30 days if no cancellation is received. You can close this tab.";

    return true;

})->name('verify_account_deletion');//verify account deletion request


Route::get('cancel-account-deletion/{email}/{id}',function (Request $request,$email,$id) {
    if (!$request->hasValidSignature()) {
        abort(401);
    }

    $user = User::where(['email' => $email,'reference' => $id])->first();
    if (empty($user)){
        abort(404);
    }
    if ($user->requestedForAccountDeletion!=1){
        return to_route('home.delete-my-information')->with('error','Account removal request not received.');
    }
    $message = "
        The user <b>".$user->name."</b> has cancelled their request for their data to be deleted, and no longer wants to remove
        their data from the platform.
    ";

    $user->requestedForAccountDeletion=2;
    $user->timeToDeleteAccount = '';
    $user->save();

    echo "Account removal successfully cancelled. You can now close this tab.";

    return;

})->name('cancel_account_deletion');//cancel account removal
