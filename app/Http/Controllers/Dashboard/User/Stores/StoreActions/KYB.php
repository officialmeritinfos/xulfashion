<?php

namespace App\Http\Controllers\Dashboard\User\Stores\StoreActions;

use App\Custom\GoogleUpload;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\State;
use App\Models\UserStore;
use App\Models\UserStoreVerification;
use App\Traits\Helpers;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class KYB extends BaseController
{
    use Helpers;
    //verify store
    public function verifyStore(): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        $country = Country::where('iso3',$user->countryCode)->first();

        return view('dashboard.users.stores.kyc')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Store KYC',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'states'        =>State::where('country_code',$country->iso2)->orderBy('name','asc')->get(),
            'store'         =>$store
        ]);
    }
    //process kyb submission
    public function processKybSubmission(Request $request): JsonResponse
    {
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $store = UserStore::where('user',$user->id)->first();
            if (empty($store)){
                return $this->sendError('store.error',['error'=>'Store not initialized.']);
            }
            $validator = Validator::make($request->all(),[
                'legalName'=>['required','string','max:200'],
                'regNumber'=>['required','string','max:50'],
                'regCert'=>['required','mimes:jpg,jpeg,png,pdf','max:2048'],
                'addressProof'=>['required','mimes:jpg,jpeg,png,pdf','max:1024'],
                'doingBusinessAs'=>['required','string','max:150'],
                'address'=>['required','string','max:200'],
            ],[],[
                'addressProof'=>'Proof of Address',
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();


            $reference = $this->generateUniqueReference('user_store_verifications','reference',8);

            if ($user->isVerified==2){
                $this->sendError('kyb.error',['error'=>'Please submit your account verification first before submitting Store KYC']);
            }

            $google = new GoogleUpload();
            //let us upload the director's proof of address
            if ($request->hasFile('addressProof')) {
                //lets upload the address proof
                $result = $google->uploadGoogle($request->file('addressProof'));
                $addressProof  = $result['link'];
            }

            //let us upload the business certificate
            if ($request->hasFile('regCert')) {
                $results = $google->uploadGoogle($request->file('regCert'));
                $certificate  = $results['link'];
            }

            //check if verification exists
            $kybExists = UserStoreVerification::where('store',$store->id)->first();
            //if empty
            if (empty($kybExists)){
                //collate business's data
                $businessData = [
                    'store'=>$store->id,
                    'reference'=>$reference,
                    'certificate'=>$certificate,
                    'addressProof'=>$addressProof,
                    'status'=>4,
                    'address'=>$input['address'],'regNumber'=>$input['regNumber'],
                    'dba'=>$input['doingBusinessAs'],'legalName'=>$input['legalName']
                ];

                //we create the document
                $verification = UserStoreVerification::create($businessData);
                if (!empty($verification)){
                    $store->isVerified=4;
                    $store->legalName=$input['legalName'];
                    $store->address=$input['address'];
                    $store->save();

                    //send notification
                    $message = "The KYC for your store ".$store->name." has been submitted and is currently under review.";
                    $this->userNotification($user,'KYC for Store submitted',$message,$request->ip());

                    //send message to admin
                    $adminMessage = "A new KYC for business account has been received from ".$user->name.". The required
                documents have been uploaded and is awaiting your review. KYC Reference ID is ".$reference;
                    $this->sendDepartmentMail('compliance', $adminMessage,'New KYB for Store Submitted.');

                    return $this->sendResponse([
                        'redirectTo'=>url()->previous()
                    ],'Your Store KYC has been received and will be reviewed shortly. ');
                }
                return $this->sendError('document.error',[
                    'error'=>'Something went wrong while processing your documents'
                ]);
            }else{
                //collate business's data
                $businessData = [
                    'certificate'=>$certificate,
                    'addressProof'=>$addressProof,
                    'status'=>4,
                    'address'=>$input['address'],'regNumber'=>$input['regNumber'],
                    'dba'=>$input['doingBusinessAs'],'legalName'=>$input['legalName']
                ];

                //we create the document
                $verification = $kybExists->update($businessData);
                $store->isVerified=4;
                $store->legalName=$input['legalName'];
                $store->address=$input['address'];
                $store->save();

                //send notification
                $message = "The KYC for your store ".$store->name." has been submitted and is currently under review.";
                $this->userNotification($user,'KYC for Store submitted',$message,$request->ip());

                //send message to admin
                $adminMessage = "A new KYC for business account has been received from ".$user->name.". The required
                documents have been uploaded and is awaiting your review. KYC Reference ID is ".$reference;
                $this->sendDepartmentMail('compliance', $adminMessage,'New KYB for Store Submitted.');

                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Your Store KYC has been received and will be reviewed shortly. ');
            }
        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' updating verification documents: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
}
