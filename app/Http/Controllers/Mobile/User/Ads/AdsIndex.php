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

class AdsIndex extends BaseController
{
    public $google;
    use Helpers;
    public function __construct()
    {
        $this->google = new GoogleUpload();
    }
    //landing page
    public function landingPage(Request $request)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $ads = UserAd::where('user',$user->id)->with('service')
            ->orderBy('status')->orderBy('created_at','desc')
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'products' => view('mobile.users.ads.components.merchant_ad_list', compact('ads'))->render(),
                'nextPage' => $ads->currentPage() + 1,
                'hasMorePages' => $ads->hasMorePages()
            ]);
        }

        return view('mobile.users.ads.index')->with([
            'pageName'  =>'Landing Page',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>$user,
            'views'     =>UserAd::where([
                'user' => $user->id,
                'status' => 1
            ])->sum('numberOfViews'),
            'totalAds'   =>UserAd::where([
                'user' => $user->id,'status' => 1
            ])->count(),
            'ads'         =>$ads
        ]);
    }
    //create new page
    public function createAd(Request $request)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $country = Country::where('iso3',$user->countryCode)->first();

        return view('mobile.users.ads.new')->with([
            'pageName'  =>'Create Ad',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>$user,
            'states'    =>State::where('country_code',$country->iso2)->orderBy('name')->get(),
            'categories'=>ServiceType::where('status',1)->get()
        ]);
    }
    //process new ad
    public function processNewAd(Request $request)
    {
        DB::beginTransaction();
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $country = Country::where('iso3',$user->countryCode)->first();

            $validator = Validator::make($request->all(),[
                'location'=>['required','alpha',Rule::exists('states','iso2')->where('country_code',$country->iso2)],
                'featuredPhoto'=>['required','image','max:2048'],
                'title'=>['required','string','max:200'],
                'companyName'=>['nullable','string','max:150'],
                'category'=>['required','integer','exists:service_types,id'],
                'description'=>['required','string'],
                'priceType'=>['required','integer','in:1,2'],
                'price'=>['nullable','required_if:priceType,2', 'numeric'],
                'negotiate'=>['required','numeric','in:1,2,3'],
                'tags'=>['nullable'],
                'tags.*'=>['nullable','string'],
                'photos'=>['nullable','array','max:'.$web->fileUploadAllowed],
                'photos.*'=>['nullable','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
                'phone'=>['nullable','numeric']
            ],[
                'photos.max'=>'You can only upload a maximum of '.$web->fileUploadAllowed.' images.',
                'photos.*.image' => 'Each file must be an image.',
                'photos.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif, svg.',
                'photos.*.max' => 'Each image may not be larger than 2MB.'
            ],[
                'negotiate'=>'Open to Negotiation',
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();

            $reference = $this->generateUniqueReference('user_ads','reference',16);
            //let us try to upload the image
            if ($request->hasFile('featuredPhoto')) {
                //lets upload the address proof
                $result = $this->google->uploadGoogle($request->file('featuredPhoto'));
                $featuredPhoto  = $result['link'];
            }

            $ad = UserAd::create([
                'user'=>$user->id,'reference'=>$reference,
                'title'=>$input['title'],'description'=>$input['description'],
                'companyName'=>$input['companyName'],'priceType'=>$input['priceType'],
                'amount'=>($input['priceType']!=1)?$input['price']:0,'serviceType'=>$input['category'],
                'state'=>$input['location'],'tags'=>implode(',',$input['tags']),
                'openToNegotiation'=>($input['priceType']!=1)?$input['negotiate']:2,'status'=>2,
                'featuredImage'=>$featuredPhoto,'currency'=>$user->mainCurrency,'country'=>$country->iso2
            ]);
            if (!empty($ad)){
                if (empty($user->phone)){
                    $user->phone = $input['phone'];
                    $user->save();
                }
                //check if photos were uploaded
                if ($request->file('photos')){
                    foreach ($request->file('photos') as $index => $item) {
                        $result = $this->google->uploadGoogle($item);
                        $fileName = $result['link'];

                        UserAdPhoto::create([
                            'ad'=>$ad->id,'photo'=>$fileName
                        ]);
                    }
                }
                DB::commit();
                $this->userNotification($user,'Ad Created','Your ad was created successfully and is pending review',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>route('mobile.user.ads.index'),
                    'redirects'=>true
                ],'Ad created successful. Redirecting soon ...');
            }
        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' while adding new ad: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
}
