<?php

namespace App\Http\Controllers\Mobile\User\Ads;

use App\Custom\GoogleUpload;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\ServiceType;
use App\Models\State;
use App\Models\UserAd;
use App\Models\UserAdPhoto;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdsEdit extends BaseController
{
    use Helpers;

    public function __construct()
    {
        $this->google = new GoogleUpload();
    }

    //landing page
    public function landingPage(Request $request, $adId)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $ad = UserAd::where([
            'user' => $user->id,'reference' => $adId
        ])->firstOrFail();

        $country = Country::where('iso3',$user->countryCode)->first();

        return view('mobile.users.ads.edit')->with([
            'pageName'  =>'Edit Ad',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>$user,
            'states'    =>State::where('country_code',$country->iso2)->orderBy('name')->get(),
            'categories'=>ServiceType::where('status',1)->get(),
            'ad'        =>$ad,
            'fashion_categories' => ServiceType::where('mainCategory','fashion')->orderBy('name')->get(),
            'beauty_categories' => ServiceType::where('mainCategory','beauty')->orderBy('name')->get(),
        ]);
    }

    public function processAdUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $country = Country::where('iso3',$user->countryCode)->first();

            $validator = Validator::make($request->all(),[
                'location'=>['required','alpha',Rule::exists('states','iso2')->where('country_code',$country->iso2)],
                'featuredPhoto'=>['nullable','image','max:4096'],
                'title'=>['required','string','max:200'],
                'companyName'=>['nullable','string','max:150'],
                'industry'=>['required','in:beauty,fashion'],
                'category'=>['required','integer','exists:service_types,id'],
                'description'=>['required','string'],
                'priceType'=>['required','integer','in:1,2'],
                'price'=>['nullable','required_if:priceType,2', 'numeric'],
                'negotiate'=>['required','numeric','in:1,2,3'],
                'tags'=>['nullable'],
                'tags.*'=>['nullable','string'],
                'photos'=>['nullable','array','max:'.$web->fileUploadAllowed],
                'ad'=>['required','string',Rule::exists('user_ads','reference')->where('user',$user->id)],
            ],[
                'industry.in'=>'Only Beauty and Fashion Industries are currently supported.',
            ],[
                'negotiate'=>'Open to Negotiation',
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();

            $ad = UserAd::where([
                'user' => $user->id,'reference' => $input['ad']
            ])->first();

            //let us try to upload the image
            if ($request->hasFile('featuredPhoto')) {
                //lets upload the address proof
                $result = $this->google->uploadGoogle($request->file('featuredPhoto'));
                $featuredPhoto  = $result['link'];
            }else{
                $featuredPhoto=$ad->featuredImage;
            }
            if (UserAd::where('id',$ad->id)->update([
                'title'=>$input['title'],'description'=>$input['description'],
                'companyName'=>$input['companyName'],'priceType'=>$input['priceType'],
                'amount'=>($input['priceType']!=1)?$input['price']:0,'serviceType'=>$input['category'],
                'state'=>$input['location'],'tags'=>implode(',',$input['tags']),
                'openToNegotiation'=>($input['priceType']!=1)?$input['negotiate']:2,'status'=>2,
                'featuredImage'=>$featuredPhoto,'currency'=>$user->mainCurrency,'country'=>$country->iso2,
                'industry'=>$input['industry'],
            ])){
                DB::commit();
                $this->userNotification($user,'Ad Updated','Your ad was updated successfully and is pending review',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>route('mobile.user.ads.detail',['id'=>$ad->reference]),
                    'redirects'=>true
                ],'Ad updated successful. Redirecting soon ...');
            }
        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' while updating ad: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
}
