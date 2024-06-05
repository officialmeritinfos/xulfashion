<?php

namespace App\Http\Controllers\Dashboard\User\Stores\StoreActions;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Mail\SendMerchantOrderPurchase;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\UserStore;
use App\Models\UserStoreCoupon;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreOrder;
use App\Models\UserStoreOrderBreakdown;
use App\Models\UserStoreProduct;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class Orders extends BaseController
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

        return view('dashboard.users.stores.components.orders.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Store Orders',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'orders'        =>UserStoreOrder::where('store',$store->id)->orderBy('id','desc')->paginate(20)
        ]);
    }
    //order details
    public function orderDetails($id)
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        $order = UserStoreOrder::where([
            'store'=>$store->id,
            'reference'=>$id
        ])->firstOrFail();

        return view('dashboard.users.stores.components.orders.details')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Store Order Detail',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'order'         =>$order,
            'customer'      =>UserStoreCustomer::where('id',$order->customer)->first(),
            'breakdowns'    =>UserStoreOrderBreakdown::where('orderId',$order->id)->get(),
            'fiat'          =>Fiat::where('code',$order->currency)->first(),
            'coupon'        =>UserStoreCoupon::where('id',$order->coupon)->first()
        ]);

    }
    //cancel order
    public function cancelOrder(Request $request,$order)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            //check if the store has already been initialized
            $store = UserStore::where('user',$user->id)->first();
            if (empty($store)){
                return $this->sendError('store.error',['error'=>'Store not initialized - initialize store first.']);
            }
            //order exists
            $orderExists = UserStoreOrder::where([
                'store'=>$store->id,
                'reference'=>$order
            ])->first();
            if (empty($orderExists)){
                return $this->sendError('order.error',['error'=>'Order not found']);
            }

            $validator = Validator::make($request->all(),[
                'password'=>['required','string','current_password:web']
            ])->stopOnFirstFailure();

            if ($validator->fails()){
                return  $this->sendError('validation.error',['error'=>$validator->errors()->all()]);
            }
            $input = $validator->validated();
            //check if payment has been completed
            if ($orderExists->status==1){
                return $this->sendError('order.error',['error'=>'Order has already been completed.']);
            }
            $breakDowns = UserStoreOrderBreakdown::where('orderId',$orderExists->id)->get();
            foreach ($breakDowns as $breakDown) {
                $product = UserStoreProduct::where([
                    'store'=>$store->id,'id'=>$breakDown->product
                ])->first();
                if (!empty($product)){
                    $product->quantity=$product->quantity+$breakDown->quantity;
                    $product->save();
                }
            }

            $orderExists->status=3;
            $orderExists->paymentStatus=3;
            $orderExists->save();

            $customer = UserStoreCustomer::where('id',$orderExists->customer)->first();
            //send mail
            $mailData=[
                'fromMail'=>$web->email,
                'title'=>"Order #".$orderExists->reference." Cancelled.",
                'siteName'=>$web->name,
                'supportMail'=>$web->supportEmail,
                'order'=>$orderExists->reference
            ];
            Mail::to($store->email)->send(new SendMerchantOrderPurchase($mailData,"Order #".$orderExists->reference." Cancelled."));
            Mail::to($customer->email)->send(new SendMerchantOrderPurchase($mailData,"Order #".$orderExists->reference." Cancelled."));

            DB::commit();
            //return response
            return $this->sendResponse([
                'redirectTo'=>url()->previous()
            ],'Order successfully cancelled.');

        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error occurred while cancelling order: '.$exception->getMessage().' on line '.$exception->getLine());
            return $this->sendError('order.error',['error'=>'Something went wrong, please try again']);
        }
    }
    //mark payment as paid
    public function markPaid(Request $request,$order)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            //check if the store has already been initialized
            $store = UserStore::where('user',$user->id)->first();
            if (empty($store)){
                return $this->sendError('store.error',['error'=>'Store not initialized - initialize store first.']);
            }
            //order exists
            $orderExists = UserStoreOrder::where([
                'store'=>$store->id,
                'reference'=>$order
            ])->first();
            if (empty($orderExists)){
                return $this->sendError('order.error',['error'=>'Order not found']);
            }

            $validator = Validator::make($request->all(),[
                'password'=>['required','string','current_password:web'],
                'amount'=>['required','numeric'],
            ])->stopOnFirstFailure();

            if ($validator->fails()){
                return  $this->sendError('validation.error',['error'=>$validator->errors()->all()]);
            }
            $input = $validator->validated();
            //check if payment has been completed
            if ($orderExists->paymentStatus==1){
                return $this->sendError('order.error',['error'=>'Payment has been received already']);
            }
            //check if payment has been completed
            if ($orderExists->order==3){
                return $this->sendError('order.error',['error'=>'Order has been cancelled already']);
            }
            $orderExists->paymentStatus=1;
            $orderExists->amountPaid=$input['amount'];
            $orderExists->status=4;
            $orderExists->save();

            $customer = UserStoreCustomer::where('id',$orderExists->customer)->first();
            //send mail
            $mailData=[
                'fromMail'=>$web->email,
                'title'=>"Payment For Order #".$orderExists->reference." received.",
                'siteName'=>$web->name,
                'supportMail'=>$web->supportEmail,
                'order'=>$orderExists->reference
            ];
            Mail::to($store->email)->send(new SendMerchantOrderPurchase($mailData,"Payment For Order #".$orderExists->reference." received."));
            Mail::to($customer->email)->send(new SendMerchantOrderPurchase($mailData,"Payment For Order #".$orderExists->reference." received."));

            //return response
            return $this->sendResponse([
                'redirectTo'=>url()->previous()
            ],'Order successfully marked as paid.');

        }catch (\Exception $exception){
            Log::info('Error occurred while marking order as paid: '.$exception->getMessage().' on line '.$exception->getLine());
            return $this->sendError('order.error',['error'=>'Something went wrong, please try again']);
        }
    }
    //complete Order
    public function completeOrder(Request $request,$order)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            //check if the store has already been initialized
            $store = UserStore::where('user',$user->id)->first();
            if (empty($store)){
                return $this->sendError('store.error',['error'=>'Store not initialized - initialize store first.']);
            }
            //order exists
            $orderExists = UserStoreOrder::where([
                'store'=>$store->id,
                'reference'=>$order
            ])->first();
            if (empty($orderExists)){
                return $this->sendError('order.error',['error'=>'Order not found']);
            }

            $validator = Validator::make($request->all(),[
                'password'=>['required','string','current_password:web']
            ])->stopOnFirstFailure();

            if ($validator->fails()){
                return  $this->sendError('validation.error',['error'=>$validator->errors()->all()]);
            }
            $input = $validator->validated();
            //check if payment has been completed
            if ($orderExists->paymentStatus!=1){
                return $this->sendError('order.error',['error'=>'Payment for order has not been received. If payment was completed offline, mark as paid first.']);
            }

            if ($orderExists->status==1){
                return $this->sendError('order.error',['error'=>'Order has been completed already']);
            }
            $orderExists->status=1;
            $orderExists->save();

            //if order was manually confirmed - payment was not completed online
            if (!empty($orderExists->channelPaymentId)){
                //owner of store
                $owner = User::where('id',$store->user)->first();
                $owner->accountBalance=$owner->accountBalance+$orderExists->amountToCredit;
                $owner->save();
            }
            $customer = UserStoreCustomer::where('id',$orderExists->customer)->first();
            //send mail
            $mailData=[
                'fromMail'=>$web->email,
                'title'=>"Order #".$orderExists->reference." completed",
                'siteName'=>$web->name,
                'supportMail'=>$web->supportEmail,
                'order'=>$orderExists->reference
            ];
            Mail::to($store->email)->send(new SendMerchantOrderPurchase($mailData,"Order #".$orderExists->reference." completed"));
            Mail::to($customer->email)->send(new SendMerchantOrderPurchase($mailData,"Order #".$orderExists->reference." completed"));

            DB::commit();

            //return response
            return $this->sendResponse([
                'redirectTo'=>url()->previous()
            ],'Order successfully completed.');

        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error occurred while completing order '.$exception->getMessage().' on line '.$exception->getLine());
            return $this->sendError('order.error',['error'=>'Something went wrong, please try again']);
        }
    }
}
