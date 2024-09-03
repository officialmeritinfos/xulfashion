<?php

use App\Http\Controllers\Company\Home;
use App\Http\Controllers\Company\LegalController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/',[Home::class,'landingPage'])->name('index');
/*================================ COMPANY CONTROLLER ==============================*/
Route::get('about',[Home::class,'about'])
    ->name('about');
/*================================ LEGAL CONTROLLER  ===============================*/
Route::get('legal',[LegalController::class,'landingPage'])
    ->name('legal');

Route::get('legal/privacy-policy',[LegalController::class,'generalPrivacy'])
    ->name('privacy-policy');
Route::get('legal/terms-and-conditions',[LegalController::class,'generalTerms'])
    ->name('terms-and-conditions');
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

    \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AccountDeletionReceived($user));
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

    $user->requestedForAccountDeletion=2;
    $user->timeToDeleteAccount = '';
    $user->save();

    echo "Account removal successfully cancelled. You can now close this tab.";

    return;

})->name('cancel_account_deletion');//cancel account removal
