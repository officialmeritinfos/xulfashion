<?php

namespace App\Http\Controllers\Mobile\Ads;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\UserAd;
use App\Models\UserAdReview;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ReviewController extends BaseController
{
    use Helpers;
    public function landingPage()
    {

    }
    //process new rating
    public function processNewRating(Request $request)
    {
        DB::beginTransaction();
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $country = Country::where('iso3',$user->countryCode)->first();

            $validator = Validator::make($request->all(),[
                'ad'=>['required','numeric',Rule::exists('users','id')],
                'review'=>['required','string','max:2000'],
                'rating'=>['required','in:1,2,3,4,5']
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();

            //fetch ad
            $merchant = User::where('id',$input['ad'])->first();

            if ($merchant->id ==$user->id){
                return $this->sendError('Review.error',[
                    'error'=>'You cannot write a review for your own profile'
                ]);
            }
            //check if user has written a review for this merchant before
            $hasReviewed = UserAdReview::where([
                'merchant'=>$merchant->id,'reviewer'=>$user->id
            ])->count();
            if ($hasReviewed >0){
                return $this->sendError('Review.error',[
                    'error'=>'To maintain transparency in our system, you can only review a merchant once. Any other reviews should be added as an update to the initial review.'
                ]);
            }

            $review = UserAdReview::create([
                'reviewer'=>$user->id,'merchant'=>$merchant->id,
                'reference'=>$this->generateUniqueReference('user_ad_reviews','reference'),
                'comment'=>$input['review'],'rating'=>$input['rating'],'status'=>1
            ]);
            if (!empty($review)){
                $message= "
                    A new review has been received on your profile on ".$web->name.". You were rated ".$input['rating']."
                ";
                scheduleUserNotification($merchant->id,'You just got rated on '.$web->name,$message,route('mobile.user.reviews.index'));

                DB::commit();

                return $this->sendResponse([
                    'redirectTo'=>url()->previous(),
                    'redirects'=>true
                ],'Your review has been sent. We will review this to ensure it is in accordance to our standard. Usually takes 24-48 hours.');
            }
        }catch(\Exception $exception){
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' while adding new review: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
}
