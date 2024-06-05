<?php

namespace App\Http\Controllers\Storefront;

use App\Custom\PaymentProcessing;
use App\Custom\Regular;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserStore;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreInvoice;
use App\Notifications\CustomNotificationMail;
use App\Traits\Helpers;
use App\Traits\Themes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class InvoiceController extends BaseController
{
    use Helpers,Themes;
    public $payment,$regular;

    public function __construct()
    {
        $this->payment=new PaymentProcessing();
        $this->regular = new Regular();
    }

    //landing page
    public function landingPage($subdomain,$id)
    {
        $web = GeneralSetting::find(1);
        $store=UserStore::where('slug',$subdomain)->firstOrFail();

        $invoice = UserStoreInvoice::where([
            'store'=>$store->id,'reference'=>$id
        ])->first();

        if ($invoice->status==3){
            abort(404);
        }

        return view('storefront.invoice',[
            'store'=>$store,
            'invoice'=>$invoice,
            'title'=>'Invoice Page',
            'customer'=>UserStoreCustomer::where('id',$invoice->customer)->first(),
            'showButton'=>1,
            'siteName'=>$web->name,
            'web'=>$web,
            'subdomain'=>$subdomain,
            'pageName'=>$invoice->title,
            'fiat'    =>Fiat::where('code',$invoice->currency)->orWhere('code','USD')->first()
        ]);
    }
    //make payment
    public function makePayment($subdomain,$orderRef)
    {
        $web = GeneralSetting::find(1);
        $store = UserStore::where('slug',$subdomain)->firstOrFail();
        $order = UserStoreInvoice::where([
            'store'=>$store->id,'reference'=>$orderRef,
        ])->first();

        try {
            $invoiceUrl = route('merchant.store.invoice.detail',['subdomain'=>$subdomain,'id'=>$orderRef]);

            $payment = $this->payment->initiateInvoicePayment($order,$store,$web);
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
    //process invoice order payment
    public function processInvoiceOrderPayment(Request $request,$subdomain,$orderRef)
    {
        $transRef = $request->get('trxref');
        $store = UserStore::where('slug',$subdomain)->firstOrFail();
        $order = UserStoreInvoice::where([
            'store'=>$store->id,'reference'=>$orderRef,
            'channelPaymentReference'=>$transRef
        ])->first();
        $customer = UserStoreCustomer::where('id',$order->customer)->first();
        $merchant = User::where('id',$store->user)->first();
        $web = GeneralSetting::find(1);

        try {
            DB::beginTransaction();
            $invoiceUrl = route('merchant.store.invoice.detail',['subdomain'=>$subdomain,'id'=>$orderRef]);
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

                    $newBalance = $merchant->accountBalance+$amountCredit;
                    $merchant->accountBalance= $merchant->accountBalance+$amountCredit;



                    Transaction::create([
                        'user'=>$merchant->id,'reference'=>$order->reference,'transactionType'=>5,
                        'amount'=>$amountCredit,'currency'=>$order->currency,'newBalance'=>$newBalance,
                        'status'=>1
                    ]);

                    $dataOrder = [
                        'paymentMethod'=>ucfirst($data['channel']),
                        'paymentStatus'=>1,'amountPaid'=>$amountPaid,
                        'charge'=>$totalCharge,'amountCredit'=>$amountCredit,
                        'channelPaymentId'=>$transId,'channelPaymentReference'=>$channelPaymentReference,
                        'datePaid'=>time(),'paymentReference'=>$channelPaymentReference,'processorFee'=>$fees,
                        'status'=>1
                    ];
                    $order->update($dataOrder);
                    $merchant->save();

                    DB::commit();;
                    //Send mail to Merchant & customer
                    $message = "
                        We have received the payment for your invoice <b>".$order->reference."</b> from the payer. THe Details are below
                        <hr/>
                        <p><b>Invoice Name:</b> ".$order->title."</p>
                        <p><b>Invoice Reference:</b> ".$order->reference."</p>
                        <p><b>Payer:</b> ".$customer->name."</p>
                        <p><b>Invoice Amount:</b> ".$order->currency.number_format($order->amount,2)."</p>
                        <p><b>Amount Paid:</b> ".$order->currency.number_format($amountPaid,2)."</p>
                        <p><b>Charge:</b> ".$order->currency.number_format($totalCharge,2)."</p>
                        <p><b>Credited:</b> ".$order->currency.number_format($amountCredit,2)."</p>
                        <br/>
                    ";
                    $merchant->notify(new CustomNotificationMail($merchant->name,'Invoice Payment received',$message));

                    return redirect()->to($invoiceUrl)->with('success', "Payment successful.");
                }elseif($data['status']=='failed'||$data['status']=='abandoned'){
                    $dataOrder = [
                        'paymentStatus'=>3
                    ];
                    $order->update($dataOrder);
                    DB::commit();;
                    //Send mail to Merchant & customer
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
            DB::rollBack();
            $ticketUrl = route('merchant.store.ticket.new',['subdomain'=>$subdomain,'reference'=>$orderRef]);
            Log::info('An error occurred while processing invoice payment '.$exception->getMessage().' on line '.$exception->getLine().' in file '.$exception->getFile());

            return redirect()->to($ticketUrl)->with('error','An error occurred while we were processing your payment. Fill up the form below to open a ticket and our support team will be on the way.');
        }
    }
}
