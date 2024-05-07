<?php

namespace App\Http\Controllers\Dashboard\User;

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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdController extends BaseController
{
    public $google;
    use Helpers;
    public function __construct()
    {
        $this->google = new GoogleUpload();
    }

    //landing page
    public function landingPage()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.users.ads.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Ads',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'ads'           =>UserAd::where('user',$user->id)->orderBy('id','desc')->paginate(),
        ]);
    }
    //new ad page
    public function newAdPage()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);
        $country = Country::where('iso3',$user->countryCode)->first();

        return view('dashboard.users.ads.new')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Post New Ad',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'states'        =>State::where('country_code',$country->iso2)->orderBy('name','asc')->get(),
            'services'      =>ServiceType::where('status',1)->get()
        ]);
    }
    //process ad creation
    public function processAdCreation(Request $request)
    {
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $country = Country::where('iso3',$user->countryCode)->first();

            $validator = Validator::make($request->all(),[
                'location'=>['required','alpha',Rule::exists('states','iso2')->where('country_code',$country->iso2)],
                'featuredPhoto'=>['required','image','max:2048'],
                'title'=>['required','string','max:200'],
                'companyName'=>['nullable','string','max:150'],
                'serviceType'=>['required','integer','exists:service_types,id'],
                'description'=>['required','string'],
                'priceType'=>['required','integer','in:1,2'],
                'price'=>['nullable','numeric'],
                'negotiate'=>['nullable','numeric','in:1,2,3'],
                'category'=>['nullable'],
                'category.*'=>['nullable','string'],
                'photos'=>['nullable'],
                'photos.*'=>['nullable','image','max:2048'],
            ],[],[
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
                'amount'=>$input['price'],'serviceType'=>$input['serviceType'],
                'state'=>$input['location'],'tags'=>implode(',',$input['category']),
                'openToNegotiation'=>$input['negotiate'],'status'=>2,
                'featuredImage'=>$featuredPhoto,'currency'=>$user->mainCurrency,'country'=>$country->iso2
            ]);
            if (!empty($ad)){
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
                $this->userNotification($user,'Ad Created','Your ad was created successfully and is pending review',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>route('user.ads.index')
                ],'Ad created successful. Redirecting soon ...');
            }
        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' while adding new ad: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
    //edit ad page
    public function editAdPage($id)
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);
        $country = Country::where('iso3',$user->countryCode)->first();

        $ad = UserAd::where([
            'reference'=>$id,'user'=>$user->id
        ])->firstOrFail();

        return view('dashboard.users.ads.edit')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Edit Ad',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'states'        =>State::where('country_code',$country->iso2)->orderBy('name','asc')->get(),
            'services'      =>ServiceType::where('status',1)->get(),
            'ad'            =>$ad
        ]);
    }
    //process edit ad
    public function processAdEdit(Request $request,$id)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);
            $country = Country::where('iso3',$user->countryCode)->first();
            $ad = UserAd::where([
                'reference'=>$id,'user'=>$user->id
            ])->first();
            if (empty($ad)){
                return $this->sendError('ad.error',['error'=>'Ad not found']);
            }

            $validator = Validator::make($request->all(),[
                'location'=>['required','alpha',Rule::exists('states','iso2')->where('country_code',$country->iso2)],
                'featuredPhoto'=>['nullable','image','max:2048'],
                'title'=>['required','string','max:200'],
                'companyName'=>['nullable','string','max:150'],
                'serviceType'=>['required','integer','exists:service_types,id'],
                'description'=>['required','string'],
                'priceType'=>['required','integer','in:1,2'],
                'price'=>['nullable','numeric'],
                'negotiate'=>['nullable','numeric','in:1,2,3'],
                'category'=>['nullable'],
                'category.*'=>['nullable','string'],
            ],[],[
                'negotiate'=>'Open to Negotiation',
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();

            //let us try to upload the image
            if ($request->hasFile('featuredPhoto')) {
                //lets upload the featured image
                $result = $this->google->uploadGoogle($request->file('featuredPhoto'));
                $featuredPhoto  = $result['link'];
            }else{
                $featuredPhoto = $ad->featuredImage;
            }

            $ad = UserAd::where('id',$ad->id)->update([
                'title'=>$input['title'],'description'=>$input['description'],
                'companyName'=>$input['companyName'],'priceType'=>$input['priceType'],
                'amount'=>$input['price'],'serviceType'=>$input['serviceType'],
                'state'=>$input['location'],'tags'=>implode(',',$input['category']),
                'openToNegotiation'=>$input['negotiate'],'status'=>2,
                'featuredImage'=>$featuredPhoto,'currency'=>$user->mainCurrency,'country'=>$country->iso2
            ]);
            if (!empty($ad)){
                return $this->sendResponse([
                    'redirectTo'=>route('user.ads.index')
                ],'Ad successfully updated. Redirecting soon ...');
            }
        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' while updating ad: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
    //delete ad
    public function deleteAd($id)
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);
        $country = Country::where('iso3',$user->countryCode)->first();

        $ad = UserAd::where([
            'reference'=>$id,'user'=>$user->id
        ])->firstOrFail();

        $ad->delete();

        return back()->with('success','Ad successfully deleted');
    }
    //ad details
    public function adDetails($id)
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);
        $country = Country::where('iso3',$user->countryCode)->first();

        $ad = UserAd::where([
            'reference'=>$id,'user'=>$user->id
        ])->firstOrFail();

        return view('dashboard.users.ads.detail')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Ad Detail',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'states'        =>State::where('country_code',$country->iso2)->where('iso2',$ad->state)->orderBy('name','asc')->first(),
            'service'       =>ServiceType::where('status',1)->where('id',$ad->serviceType)->first(),
            'ad'            =>$ad,
            'photos'        =>UserAdPhoto::where('ad',$ad->id)->get()
        ]);
    }
    //delete ad
    public function deleteAdPhoto($ads,$id)
    {
        $user = Auth::user();

        $ad = UserAd::where([
            'reference'=>$ads,'user'=>$user->id
        ])->firstOrFail();

        UserAdPhoto::where([
            'ad'=>$ad->id,'id'=>$id
        ])->delete();

        return back()->with('success','Photo successfully deleted');
    }
    //add ad photos
    public function processAdPhotoUpload(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $ad = UserAd::where([
                'reference'=>$id,'user'=>$user->id
            ])->first();
            if (empty($ad)){
                return $this->sendError('ad.error',['error'=>'Ad not found']);
            }

            $validator = Validator::make($request->all(),[
                'photos'=>['nullable'],
                'photos.*'=>['nullable','image','max:2048'],
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
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
            return $this->sendResponse([
                'redirectTo'=>url()->previous()
            ],'Image upload successful');

        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' while adding ad photo: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
}
