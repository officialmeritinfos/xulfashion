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
Route::get('faq',[Home::class,'faq'])
    ->name('faq');
Route::get('pricing',[Home::class,'pricing'])
    ->name('pricing');
Route::get('contact',[Home::class,'contact'])
    ->name('contact');
Route::get('career',[Home::class,'career'])
    ->name('career');
Route::get('features',[Home::class,'features'])
    ->name('features');
Route::get('download-page',[Home::class,'download'])
    ->name('download');
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
