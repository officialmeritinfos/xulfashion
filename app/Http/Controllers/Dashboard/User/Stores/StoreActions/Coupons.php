<?php

namespace App\Http\Controllers\Dashboard\User\Stores\StoreActions;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\State;
use App\Models\UserStore;
use App\Models\UserStoreCoupon;
use App\Traits\Helpers;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Coupons extends BaseController
{
    use Helpers;
    //landing page
    public function landingPage()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }

        return view('dashboard.users.stores.components.coupons.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Store Coupons',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'coupons'       =>UserStoreCoupon::where('store',$store->id)->orderBy('status','asc')->orderBy('id','desc')->paginate(20)
        ]);
    }
    //add new
    public function addNew(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }

        return view('dashboard.users.stores.components.coupons.new')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Add Store Coupon',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
        ]);
    }
    public function processNewCoupon(Request $request)
    {
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $store = UserStore::where('user',$user->id)->first();
            if (empty($store)){
                return $this->sendError('store.error',['error'=>'Store not initialized.']);
            }
            $validator = Validator::make($request->all(),[
                'name'=>['required','string','max:200'],
                'couponType'=>['required','numeric','in:1,2'],
                'discount'=>['required','numeric'],
                'useLimit'=>['nullable','numeric'],
                'usageLimit'=>['nullable','numeric'],
                'couponEnd'=>['nullable','string','max:200'],
                'deadline'=>['nullable','date','after:today'],
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();


            $reference = $this->generateUniqueReference('user_store_coupons','reference',7);

            $coupon = UserStoreCoupon::create([
                'store'=>$store->id,'code'=>$input['name'],'reference'=>$reference,
                'couponType'=>$input['couponType'],'currency'=>$store->currency,
                'discount'=>$input['discount'],'limitedByUse'=>($request->has('useLimit'))?1:2,
                'useLimit'=>$input['usageLimit'],'deactivateByDate'=>($request->has('couponEnd'))?1:2,
                'usageDeadline'=>strtotime($input['deadline']),'generatedBy'=>$user->id
            ]);

            if(!empty($coupon)){
                $this->userNotification($user,'Store coupon added','A new coupon has been added to your store.',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>($request->has('addAnother'))?url()->previous():route('user.stores.coupons')
                ],'Coupon successfully added. Redirecting soon ...');
            }
        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' adding store coupon: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
    //delete coupon
    public function deleteCoupon($id): RedirectResponse
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized.');
        }

        $coupon = UserStoreCoupon::where([
            'store'=>$store->id,'reference'=>$id
        ])->first();
        if (empty($coupon)){
            return back()->with('error','Unable to find coupon');
        }
        $coupon->delete();
        return back()->with('success','Coupon deleted');
    }
    //edit coupon
    public function editCouponPage($id)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized.');
        }

        $coupon = UserStoreCoupon::where([
            'store'=>$store->id,'reference'=>$id
        ])->first();
        if (empty($coupon)){
            return back()->with('error','Unable to find coupon');
        }

        return view('dashboard.users.stores.components.coupons.edit')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Edit Store Coupon',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'coupon'        =>$coupon
        ]);
    }
    public function processEditCoupon(Request $request,$id)
    {
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $store = UserStore::where('user',$user->id)->first();
            if (empty($store)){
                return $this->sendError('store.error',['error'=>'Store not initialized.']);
            }
            $coupon = UserStoreCoupon::where([
                'store'=>$store->id,'reference'=>$id
            ])->first();
            if (empty($coupon)){
                return $this->sendError('coupon.error',['error'=>'Store coupon not found.']);
            }

            $validator = Validator::make($request->all(),[
                'name'=>['required','string','max:200'],
                'couponType'=>['required','numeric','in:1,2'],
                'discount'=>['required','numeric'],
                'useLimit'=>['nullable','numeric'],
                'usageLimit'=>['nullable','numeric'],
                'couponEnd'=>['nullable','string','max:200'],
                'deadline'=>['nullable','date','after:today'],
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();

            $coupon = UserStoreCoupon::where('id',$coupon->id)->update([
                'code'=>$input['name'],
                'couponType'=>$input['couponType'],'currency'=>$store->currency,
                'discount'=>$input['discount'],'limitedByUse'=>($request->has('useLimit'))?1:2,
                'useLimit'=>$input['usageLimit'],'deactivateByDate'=>($request->has('couponEnd'))?1:2,
                'usageDeadline'=>strtotime($input['deadline']),'status'=>1
            ]);

            if(!empty($coupon)){
                return $this->sendResponse([
                    'redirectTo'=>route('user.stores.coupons')
                ],'Coupon successfully updated. Redirecting soon ...');
            }
        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' adding store coupon: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
}
