<?php

namespace App\Http\Controllers\Storefront;

use App\Custom\PaymentProcessing;
use App\Custom\Regular;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Mail\SendMerchantOrderPurchase;
use App\Models\Country;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\State;
use App\Models\UserStore;
use App\Models\UserStoreCoupon;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreOrder;
use App\Models\UserStoreOrderBreakdown;
use App\Models\UserStoreProduct;
use App\Models\UserStoreSetting;
use App\Notifications\CustomNotificationMail;
use App\Traits\Helpers;
use App\Traits\Themes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mockery\Exception;

class CheckoutController extends BaseController
{
    use Helpers,Themes;
    public $payment,$regular;

    public function __construct()
    {
        $this->payment=new PaymentProcessing();
        $this->regular = new Regular();
    }

    //landing page
    public function landingPage($store)
    {
        $userStore = UserStore::where('slug',$store)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store',$userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);

        $web = GeneralSetting::find(1);

        $data=[
            'userStore'       =>$userStore,
            'storeSetting'    =>$storeSettings,
            'web'             =>$web,
            'siteName'        =>$web->name,
            'pageName'        =>'Checkout Page',
            'countries'       =>Country::where('status',1)->get()
        ];
        return view('storefront.'.$themeLocation.'.checkout')->with($data);
    }
    //order summary
    public function getCartSummary($subdomain)
    {
        try {
            $cart = session()->get('cart', []);
            $couponData = session()->get('coupon', ['coupon_discount' => 0]);

            $store = UserStore::where('slug', $subdomain)->first();
            if (!$store) {
                return response()->json(['success' => false, 'message' => 'Store not found.']);
            }

            $storeFiat = Fiat::where('code', $store->currency)->first();

            $bagTotal = 0;
            foreach ($cart as $item) {
                $bagTotal += $item['quantity'] * $item['price'];
            }

            $couponDiscount = $couponData['coupon_discount'];
            $totalAmount = $bagTotal - $couponDiscount;

            $view = view('storefront.theme1.previews.checkout_section', [
                'bagTotal' => $bagTotal,
                'discount' => $couponDiscount,
                'totalAmount' => $totalAmount,
                'sign' => $storeFiat->sign,
                'hasCoupon' => session()->has('coupon'),
                'couponCode' => session('coupon.couponCode', '')
            ])->render();

            return response()->json(['success' => true, 'html' => $view]);

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while fetching the order summary.']);
        }
    }
    //process checkout
    public function processCheckout(Request $request, $subdomain)
    {
        $web = GeneralSetting::find(1);
        $store = UserStore::where('slug', $subdomain)->first();
        if (!$store) {
            return $this->sendError('store.error', ['error' => 'Store not found.']);
        }
        $settings = UserStoreSetting::where('store',$store->id)->first();
        // Validate input
        $validated = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'sometimes|required|string|max:15',
            'address'       => 'required|string|max:255',
            'city'          => 'required|string|max:150',
            'country'       => ['required','string','max:3',Rule::exists('countries','iso3')->where('status',1)],
            'state'         =>['required','string','max:30'],
            'checkoutType'  =>['required','numeric','in:1,2']
        ])->stopOnFirstFailure();

        if ($validated->fails()){
            return $this->sendError('validation.error',['error'=>$validated->errors()->all()]);
        }

        $input = $validated->validated();

        try {
            DB::beginTransaction();
            $country = Country::where('iso3',$input['country'])->first();

            $state = State::where([
                'country_code'=>$country->iso2,'iso2'=>$input['state']
            ])->first();
            if (empty($state)){
                return  $this->sendError('state.error',['error'=>'The selected state does not exist in the country']);
            }
            //create the customer
            $customerRef = $this->generateUniqueReference('user_store_customers','reference');
            $customer = UserStoreCustomer::firstOrCreate(
                ['email'=>$input['email'],'store'=>$store->id],
                [
                    'country'=>$country->iso3,'state'=>$state->iso2,'phone'=>$request->phone,
                    'address'=>$input['address'],'name'=>$input['name'],'city'=>$input['city'],'status'=>1,
                    'reference'=>$customerRef
                ]
            );

            $orderRef = $this->generateUniqueReference('user_store_orders','reference');
            $paymentReference = $this->generateUniqueReference('user_store_orders','paymentReference');

            $couponData = session()->get('coupon', ['coupon_discount' => 0]);

            // Create the order
            $order = UserStoreOrder::create([
                'store' => $store->id,'customer'=>$customer->id,'paymentStatus'=>2,
                'amount' => 0,'coupon'=>session()->has('coupon')?$couponData['couponId']:'','currency'=>$store->currency,
                'status'=>2,'reference'=>$orderRef,'checkoutType'=>$input['checkoutType'],
                'completedOnWhatsapp'=>($input['checkoutType']==1)?1:2,'paymentReference'=>$paymentReference
            ]);

            // Fetch cart and coupon details from session
            $cart = session()->get('cart', []);
            $couponData = session()->get('coupon', ['coupon_discount' => 0]);
            $bagTotal = 0;

            // Add products to order breakdown
            foreach ($cart as $item) {
                $lineTotal = $item['quantity'] * $item['price'];
                $bagTotal += $lineTotal;
                $product = UserStoreProduct::where([
                    'store'=>$store->id,'id'=>$item['product_id']
                ])->first();

                $product->quantity = $product->quantity-$item['quantity'];

                UserStoreOrderBreakdown::create([
                    'orderId' => $order->id,
                    'store'=>$store->id,
                    'product' => $product->id,
                    'quantity' => $item['quantity'],
                    'amount' => $item['price'],
                    'totalAmount' => $lineTotal,
                    'sizeVariants'=>$item['size_name'],
                    'colorVariant'=>$item['color_name']
                ]);
                $product->save();
            }
            // Apply coupon discount if any
            $couponDiscount = $couponData['coupon_discount'];
            $totalAmount = $bagTotal - $couponDiscount;

            // Update order total amount
            $order->update([
                'totalAmountToPay' => $totalAmount,
                'coupon'    =>session()->has('coupon')?$couponData['couponId']:'',
                'amount'=>$bagTotal,'discount'=>$couponDiscount
            ]);

            if (session()->has('coupon')){
                $coupon = UserStoreCoupon::where([
                    'store'=>$store->id,'id'=>$couponData['couponId']
                ])->first();
                $coupon->numberOfUsage=$coupon->numberOfUsage+1;
                $coupon->save();
            }

            //determine where to redirect the user to

            session()->put('order',$orderRef);

            $checkoutType = ($input['checkoutType']==1)?'Whatsapp':'Online';

            //send mail to merchant and customer
            $mailData=[
                'fromMail'=>$web->email,
                'title'=>'New Order Received',
                'siteName'=>$web->name,
                'supportMail'=>$web->supportEmail,
                'order'=>$orderRef
            ];
            Mail::to($store->email)->send(new SendMerchantOrderPurchase($mailData,'New Order Received'));

            Mail::to($customer->email)->send(new SendMerchantOrderPurchase($mailData,'Pending Order Payment'));

            $invoiceUrl = route('merchant.store.checkout.order.invoice',['subdomain'=>$subdomain,'id'=>$orderRef]);

            if ($input['checkoutType']==1){

                // Generate WhatsApp message
                $itemsText = "";
                foreach ($cart as $item) {
                    $product = UserStoreProduct::where([
                        'store'=>$store->id,'id'=>$item['product_id']
                    ])->first();
                    $lineTotal = $item['quantity'] * $item['price'];
                    $itemsText .= "*Product:* {$product->name}\n";
                    $itemsText .= "Quantity: {$item['quantity']}\n";
                    $itemsText .= "Price: {$store->currency} {$item['price']}\n";
                    $itemsText .= "Line Total: {$store->currency} {$lineTotal}\n\n";
                }

                $couponText = $couponDiscount > 0 ? "Discount: -{$store->currency} {$couponDiscount}\n" : "No discount applied\n";
                $summaryText="I just placed an order on your store and the details are below \n\n";
                $summaryText .= "*Order Summary:*\n\n";
                $summaryText .= $itemsText;
                $summaryText .= "Bag Total: {$store->currency} {$bagTotal}\n";
                $summaryText .= $couponText;
                $summaryText .= "Total Amount: {$store->currency} {$totalAmount}\n\n";
                $summaryText .= "*Invoice Url:* {$invoiceUrl}";

                $url = "https://wa.me/".$settings->whatsappContact.'?text='.urlencode($summaryText);
                $message = "Order processed. Redirecting to the appropriate page.";
                session()->forget(['coupon','cart']);

            }else{
                //process if payment method is Online; we determine the currency first and then begin the processing
                $fetchedOrder = UserStoreOrder::where(['store'=>$store->id,'reference'=>$orderRef])->first();
                $payment = $this->payment->initiateOrderPayment($fetchedOrder,$store,$web);
                if ($payment['result']){
                    $url=$payment['url'];
                    $fetchedOrder->channelPaymentReference = $payment['reference'];
                    $fetchedOrder->save();
                    $message = "Order processed. Redirecting to the appropriate page.";
                    session()->forget(['coupon','cart']);
                }else{
                    $url=$invoiceUrl;
                    $message = $payment['message'];
                }
            }

            DB::commit();


            return $this->sendResponse([
                'redirectTo'=>$url
            ],$message);
        }catch (\Exception $exception) {
            DB::rollBack();

            Log::error($exception->getMessage().' on line '.$exception->getLine());
            return $this->sendError('checkout.error',['error'=>'An error occurred while processing checkout.']);
        }
    }
    // checkout invoice
    public function checkoutInvoice($subdomain,$orderRef)
    {
        $store = UserStore::where('slug',$subdomain)->first();

        $order = UserStoreOrder::where(['reference'=>$orderRef,'store'=>$store->id])->firstOrFail();
        $breakDown = UserStoreOrderBreakdown::where('orderId',$order->id)->get();
        $storeSettings = UserStoreSetting::where('store',$store->id)->first();
        $web = GeneralSetting::find(1);

        return view('emails.send_merchant_order_purchase',[
            'store'=>$store,
            'order'=>$order,
            'items'=>$breakDown,
            'settings'=>$storeSettings,
            'title'=>'Order Purchase',
            'customer'=>UserStoreCustomer::where('id',$order->customer)->first(),
            'showButton'=>1,
            'coupon' =>UserStoreCoupon::where('id',$order->coupon)->first(),
            'siteName'=>$web->name,
            'web'=>$web,
            'viewMailButton'=>2,
            'subdomain'=>$subdomain
        ]);
    }
    //process checkout order payment
    public function processCheckoutOrderPayment(Request $request,$subdomain,$orderRef)
    {
        $transRef = $request->get('trxref');
        $store = UserStore::where('slug',$subdomain)->firstOrFail();
        $order = UserStoreOrder::where([
            'store'=>$store->id,'reference'=>$orderRef,
            'channelPaymentReference'=>$transRef
        ])->first();
        $customer = UserStoreCustomer::where('id',$order->customer)->first();
        $web = GeneralSetting::find(1);

        try {
            $invoiceUrl = route('merchant.store.checkout.order.invoice',['subdomain'=>$subdomain,'id'=>$orderRef]);
            $fiat = Fiat::where('code',$order->currency)->first();
            $response = $this->payment->verifyOrderPayment($order,$transRef);
            if ($response['result']){
                $data = $response['data']['data'];
                //if payment was successful
                if ($data['status']=='success'){
                    //payment was completed
                    $transId = $data['id'];
                    $channelPaymentReference=$data['reference'];
                    $amountPaidSubUnit = $data['amount'];
                    $feesUnit = $data['fees'];
                    $amountPaid = $amountPaidSubUnit/$fiat->subUnit;
                    $fees = $feesUnit/$fiat->subUnit;
                    $totalCharge = $this->regular->calculateChargeOnAmount($amountPaid,$order->currency);
                    $amountCredit = $amountPaid-$totalCharge;


                    $dataOrder = [
                        'paymentMethod'=>ucfirst($data['channel']),
                        'paymentStatus'=>1,'status'=>4,'amountPaid'=>$amountPaid,
                        'charge'=>$totalCharge,'amountToCredit'=>$amountCredit,
                        'channelPaymentId'=>$transId,'channelPaymentReference'=>$channelPaymentReference,
                        'datePaid'=>time(),'processorFee'=>$fees
                    ];
                    $order->update($dataOrder);

                    //Send mail to Merchant & customer
                    $mailData=[
                        'fromMail'=>$web->email,
                        'title'=>"Payment For Order #".$order->reference." received.",
                        'siteName'=>$web->name,
                        'supportMail'=>$web->supportEmail,
                        'order'=>$orderRef
                    ];
                    Mail::to($store->email)->send(new SendMerchantOrderPurchase($mailData,"Payment For Order #".$order->reference." received."));
                    Mail::to($customer->email)->send(new SendMerchantOrderPurchase($mailData,"Payment For Order #".$order->reference." received."));

                    return redirect()->to($invoiceUrl)->with('success', "Payment successful, order is being processed.");
                }elseif($data['status']=='failed'||$data['status']=='abandoned'){
                    $dataOrder = [
                        'paymentStatus'=>3,'status'=>3,
                    ];
                    $order->update($dataOrder);
                    //Send mail to Merchant & customer
                    $mailData=[
                        'fromMail'=>$web->email,
                        'title'=>"Payment Failed for Order #".$order->reference,
                        'siteName'=>$web->name,
                        'supportMail'=>$web->supportEmail,
                        'order'=>$orderRef
                    ];
                    Mail::to($store->email)->send(new SendMerchantOrderPurchase($mailData,"Payment Failed for Order #".$order->reference));
                    Mail::to($customer->email)->send(new SendMerchantOrderPurchase($mailData,"Payment Failed for Order #".$order->reference));

                    return redirect()->to($invoiceUrl)->with('error', "Payment failed/cancelled.");
                }else{
                    //the payment is either pending or ongoing so we return to the invoice page
                    return redirect()->to($invoiceUrl)->with('info', "No actions detected. Please contact support or retry your payment attempt.");
                }
            }else{
                $ticketUrl = route('merchant.store.ticket.new',['subdomain'=>$subdomain,'reference'=>$orderRef]);
                return redirect()->to($ticketUrl)->with('error','An error occurred while we were processing your payment.
                Fill up the form below to open a ticket and our support team will be on the way. Use this code in your error reporting
                '.$response['message']);
            }
        }catch (Exception $exception){
            $ticketUrl = route('merchant.store.ticket.new',['subdomain'=>$subdomain,'reference'=>$orderRef]);
            Log::info('An error occurred while processing checkout order payment '.$exception->getMessage().' on line '.$exception->getLine().' in file '.$exception->getFile());

            return redirect()->to($ticketUrl)->with('error','An error occurred while we were processing your payment. Fill up the form below to open a ticket and our support team will be on the way.');
        }
    }
    //make payment for order
    public function makePaymentForOrder(Request $request,$subdomain,$orderRef)
    {
        $web = GeneralSetting::find(1);
        $store = UserStore::where('slug',$subdomain)->firstOrFail();
        $order = UserStoreOrder::where([
            'store'=>$store->id,'reference'=>$orderRef,
        ])->first();

        try {
            $invoiceUrl = route('merchant.store.checkout.order.invoice',['subdomain'=>$subdomain,'id'=>$orderRef]);

            $payment = $this->payment->initiateOrderPayment($order,$store,$web);
            if ($payment['result']){
                $url=$payment['url'];
                $order->channelPaymentReference = $payment['reference'];
                $order->save();
                $message = "Redirecting to payment processor";
            }else{
                $url=$invoiceUrl;
                $message = $payment['message'];
            }
            return $this->sendResponse([
                'redirectTo'=>$url
            ],$message);
        }catch (\Exception $exception){
            Log::info('An error occurred while initiating payment for order '.$orderRef.' with error '.$exception->getMessage().' on line '.$exception->getLine().' in file '.$exception->getFile());
        }
    }

}
