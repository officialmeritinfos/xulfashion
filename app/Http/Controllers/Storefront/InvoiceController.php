<?php

namespace App\Http\Controllers\Storefront;

use App\Custom\PaymentProcessing;
use App\Custom\Regular;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Mail\InvoicePaymentReceived;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserStore;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreInvoice;
use App\Notifications\CustomNotificationMail;
use App\Services\Payments\FlutterwaveGateway;
use App\Services\Payments\NombaGateway;
use App\Services\Payments\PaystackGateway;
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
    protected PaymentProcessing $payment;
    protected Regular $regular;
    protected NombaGateway $nombaGateway;
    protected FlutterwaveGateway $flutterwaveGateway;

    public function __construct(NombaGateway $nombaGateway, FlutterwaveGateway $flutterwaveGateway, PaymentProcessing $payment, Regular $regular)
    {
        $this->nombaGateway = $nombaGateway;
        $this->flutterwaveGateway = $flutterwaveGateway;
        $this->payment= $payment;
        $this->regular = $regular;
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

        // Check if Nomba Gateway is available
        if (!$this->nombaGateway->accessToken) {
            Log::warning('Nomba gateway is unavailable. Showing limited features.');
            session()->flash('error', 'Payment processing is temporarily unavailable. Please try again later.');
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
    /**
     * Initiates payment for a store invoice using the appropriate payment gateway.
     *
     * @param string $subdomain  The store's subdomain.
     * @param string $orderRef   The invoice reference number.
     * @return \Illuminate\Http\JsonResponse  Payment URL or error response.
     */
    public function makePayment(string $subdomain, string $orderRef)
    {
        try {
            // Retrieve general settings, store, and invoice details
            $settings = GeneralSetting::find(1);
            $store = UserStore::where('slug', $subdomain)->firstOrFail();
            $order = UserStoreInvoice::where([
                'store' => $store->id,
                'reference' => $orderRef,
            ])->with('customers')->firstOrFail();

            // Generate unique payment reference and save it
            $paymentReference = $this->generateUniqueReference('user_store_invoices', 'paymentReference', 7);
            $order->paymentReference = $paymentReference;

            $order->save();

            // Select the payment gateway based on currency
            $paymentGateway = $this->selectPaymentGateway($order->currency);

            // Prepare payment data for gateway initialization
            $paymentData = [
                'amount'       => $order->amount,
                'email'        => $order->customers->email ?? $settings->email,
                'reference'    => $paymentReference,
                'callback_url' => route('merchant.store.invoice.payment.process', [
                    'subdomain' => $store->slug,
                    'id' => $order->reference
                ]),
                'currency'     => $order->currency
            ];

            // Initialize payment with card payment channel
            $paymentResponse = $paymentGateway->initializePayment($paymentData, [
                'channels' => ['card'],
            ]);

            // Handle payment initialization failure
            if (!$paymentResponse['status']) {

                logger( $paymentResponse);
                return $this->sendError('invoice.checkout.error', [
                    'error' => 'An error occurred while initiating payment for invoice ' . $orderRef . '.'
                ]);
            }

            // Save the payment gateway reference and redirect URL
            $order->channelPaymentReference = $paymentResponse['data']['orderReference'];
            $order->save();

            // Return payment URL for redirection
            return $this->sendResponse([
                'redirectTo' => $paymentResponse['data']['payment_url'],
            ], 'Payment initiated - redirecting to checkout page');

        } catch (\Exception $exception) {
            // Log error and return user-friendly error response
            Log::error("Payment initiation failed for order {$orderRef}: {$exception->getMessage()} on line {$exception->getLine()}");
            return $this->sendError('invoice.checkout.error', [
                'error' => 'An error occurred while initiating payment for invoice ' . $orderRef . '.'
            ]);
        }
    }

    //process invoice order payment
    public function processInvoiceOrderPayment(Request $request,$subdomain,$orderRef)
    {
        $transRef = $request->get('tx_ref')??$request->get('orderReference')??null;
        $paymentId = $request->get('transaction_id')??$request->get('orderId')??null;

        $store = UserStore::where('slug',$subdomain)->firstOrFail();
        $order = UserStoreInvoice::where([
            'store'=>$store->id,'reference'=>$orderRef,
        ])->with('customers')->firstOrFail();
        $customer =$order->customers;

        $merchant = User::where('id',$store->user)->first();
        $web = GeneralSetting::find(1);

        $order->update([
            'channelPaymentReference' => $order->paymentReference,
            'channelPaymentId' => $paymentId
        ]);
        $order->refresh();
        $invoiceUrl = route('merchant.store.invoice.detail',['subdomain'=>$subdomain,'id'=>$orderRef]);

        try {
            DB::beginTransaction();
            $fiat = Fiat::where('code',$order->currency)->first();

            if ($order->currency==='NGN'){
                $paymentReference = $order->channelPaymentReference;
            }else{
                $paymentReference = $order->channelPaymentId;
            }
            // Select the payment gateway based on currency
            $paymentGateway = $this->selectPaymentGateway($order->currency);
            $response = $paymentGateway->verifyPayment($paymentReference);

            if ($response['status']) {
                if ($response['data']['status']){
                    if ($response['data']['amount'] >= $order->amount) {
                        $data = $response['data'];
                        //payment was completed
                        $transId = $data['id'];
                        $channelPaymentReference=$data['reference'];
                        $amountPaid = $data['amount'];
                        $fees = $data['fees'];
                        $totalCharge = $this->regular->calculateChargeOnAmount($amountPaid,$order->currency);
                        $amountCredit = $amountPaid-$totalCharge;

                        if ($store->isVerified!=1){
                            $newBalance = bcadd($merchant->pendingBalanceStore,$amountCredit,2);
                            $merchant->pendingBalance= bcadd($merchant->pendingBalance,$amountCredit,2);
                            $merchant->pendingBalanceStore= bcadd($merchant->pendingBalanceStore,$amountCredit,2);
                        }else{
                            $newBalance = bcadd($merchant->accountBalance,$amountCredit,2);
                            $merchant->accountBalance= bcadd($merchant->accountBalance,$amountCredit,2);
                        }

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
                        //send mail to merchant
                        Mail::to($merchant->email)->queue(new InvoicePaymentReceived($merchant, $order,$customer,$amountPaid,$totalCharge,$amountCredit));
                        return redirect()->to($invoiceUrl)->with('success', "Payment successful.");
                    }
                }else{
                    return redirect()->to($invoiceUrl)->with('info', $response['message']??'Payment not received or transaction was cancelled.');
                }
            }else{
                return redirect()->to($invoiceUrl)->with('error',$response['message'].'. If this persists, contact your merchant about this.');
            }
        }catch (Exception $exception){
            DB::rollBack();
            $ticketUrl = route('merchant.store.ticket.new',['subdomain'=>$subdomain,'reference'=>$orderRef]);
            Log::info('An error occurred while processing invoice payment '.$exception->getMessage().' on line '.$exception->getLine().' in file '.$exception->getFile());

            return redirect()->to($ticketUrl)->with('error','An error occurred while we were processing your payment. Fill up the form below to open a ticket and our support team will be on the way.');
        }
    }

    private function selectPaymentGateway($currency)
    {
        return strtoupper($currency) === 'NGN' ? $this->nombaGateway : $this->flutterwaveGateway;
    }
}
