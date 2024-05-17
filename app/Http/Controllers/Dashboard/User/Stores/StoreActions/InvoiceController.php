<?php

namespace App\Http\Controllers\Dashboard\User\Stores\StoreActions;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreInvoice;
use App\Notifications\NotifyCustomer;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends BaseController
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

        return view('dashboard.users.stores.components.invoices.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Store Invoices',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'invoices'      =>UserStoreInvoice::where('store',$store->id)->paginate(20)
        ]);
    }
    //process new invoice
    public function processNewInvoice(Request $request)
    {
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $store = UserStore::where('user',$user->id)->first();
            if (empty($store)){
                return $this->sendError('store.error',['error'=>'Store not initialized.']);
            }
            $validator = Validator::make($request->all(),[
                'itemName'=>[ 'required'],
                'itemName.*'=>['required','string','max:200'],
                'itemPrice'=>['required'],
                'itemPrice.*'=>['required','numeric'],
                'itemQuantity'=>['required'],
                'itemQuantity.*'=>['required','numeric'],
                'title'=>['required','string','max:200'],
                'description'=>['required','string'],
                'name'=>['required','string','max:200'],
                'email'=>['nullable','string','email:rfc,filter','max:200'],
                'phone'=>['required','string','max:150'],
            ])->stopOnFirstFailure();
            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }

            $input = $validator->validated();
            $reference = $this->generateUniqueReference('user_store_invoices','reference',5);

            //check if customer exists or create profile
            $customer = UserStoreCustomer::firstOrCreate([
                'store'=>$store->id,'phone'=>$input['phone']
            ],[
                'name'=>$input['name'],'reference'=>$this->generateUniqueReference('user_store_customers','reference'),
                'email'=>$input['email'],'status'=>1
            ]);

            $amounts = $input['itemPrice'];
            $quantities = $input['itemQuantity'];
            $result = [];

            foreach ($amounts as $key => $amount) {
                $result[] = $amount * $quantities[$key];
            }

            $invoice = UserStoreInvoice::create([
                'store'=>$store->id,'title'=>$input['title'],
                'description'=>clean($input['description']),'currency'=>$store->currency,
                'reference'=>$reference,'amountPaid'=>0,
                'amount'=>array_sum($result),'items'=>implode(',',$input['itemName']),
                'itemPrice'=>implode(',',$input['itemPrice']),'itemQuantity'=>implode(',',$input['itemQuantity']),
                'customer'=>$customer->id
            ]);
            if (!empty($invoice)){
                //send notification
                $message = "An invoice was generated in the store ".$store->name." for the customer ".$customer->name." with number ".$customer->phone;
                $this->userNotification($user,'New Store Invoice Generated',$message,$request->ip());

                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Invoice successfully generated.');
            }

        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' while adding store invoice: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
    //edit invoice
    public function editInvoice($id)
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }

        $invoice = UserStoreInvoice::where('store',$store->id)->where('reference',$id)->firstOrFail();


        return view('dashboard.users.stores.components.invoices.edit')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Edit Store Invoice',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'invoice'       =>$invoice,
            'customer'      =>UserStoreCustomer::where('id',$invoice->customer)->first()
        ]);
    }
    //process edit invoice
    public function processEditInvoice(Request $request,$id)
    {
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $store = UserStore::where('user',$user->id)->first();
            if (empty($store)){
                return $this->sendError('store.error',['error'=>'Store not initialized.']);
            }
            $invoice = UserStoreInvoice::where([
                'store'=>$store->id,'reference'=>$id
            ])->first();
            if (empty($invoice)){
                return $this->sendError('invoice.error',['error'=>'Invoice not found.']);
            }
            $validator = Validator::make($request->all(),[
                'itemName'=>[ 'required'],
                'itemName.*'=>['required','string','max:200'],
                'itemPrice'=>['required'],
                'itemPrice.*'=>['required','numeric'],
                'itemQuantity'=>['required'],
                'itemQuantity.*'=>['required','numeric'],
                'title'=>['required','string','max:200'],
                'description'=>['required','string'],
                'status'=>['required','numeric'],
            ])->stopOnFirstFailure();
            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }

            $input = $validator->validated();

            $amounts = $input['itemPrice'];
            $quantities = $input['itemQuantity'];
            $result = [];

            foreach ($amounts as $key => $amount) {
                $result[] = $amount * $quantities[$key];
            }

            if (UserStoreInvoice::where('id',$invoice->id)->update([
                'title'=>$input['title'],'description'=>clean($input['description']),'currency'=>$store->currency,
                'amountPaid'=>0,'amount'=>array_sum($result),'items'=>implode(',',$input['itemName']),
                'itemPrice'=>implode(',',$input['itemPrice']),'itemQuantity'=>implode(',',$input['itemQuantity']),
                'status'=>$input['status']
            ])){
                return $this->sendResponse([
                    'redirectTo'=>route('user.stores.invoices')
                ],'Invoice successfully updated.');
            }

        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' while updating invoice: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
    //invoice details
    public function invoiceDetail($id)
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }

        $invoice = UserStoreInvoice::where('store',$store->id)->where('reference',$id)->firstOrFail();


        return view('dashboard.users.stores.components.invoices.detail')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Store Invoice Detail',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'invoice'       =>$invoice,
            'customer'      =>UserStoreCustomer::where('id',$invoice->customer)->first(),
            'fiat'          =>Fiat::where('code',$invoice->currency)->orWhere('code','USD')->first()
        ]);
    }
    //process notifying payer
    public function processNotifyPayer(Request $request,$id)
    {
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $store = UserStore::where('user',$user->id)->first();
            if (empty($store)){
                return $this->sendError('store.error',['error'=>'Store not initialized.']);
            }
            $invoice = UserStoreInvoice::where([
                'store'=>$store->id,'reference'=>$id
            ])->first();
            if (empty($invoice)){
                return $this->sendError('invoice.error',['error'=>'Invoice not found.']);
            }

            $customer = UserStoreCustomer::where('id',$invoice->customer)->first();
            if (empty($customer)){
                return $this->sendError('customer.error',['error'=>'Customer not found.']);
            }

            if (empty($customer->email)){
                return $this->sendError('customer.error',['error'=>'An email account not found for customer']);
            }

            $actionLink = route('merchant.store.invoice.detail',['subdomain'=>$store->slug,'id'=>$invoice->reference]);
            $message = "You have an unpaid invoice issued to you by <b>".$store->name."</b>. This invoice is for
<b>".$invoice->title."</b> and requires your attention immediately. Click the button below to proceed to make payment for the invoice";

            $customer->notify(new NotifyCustomer($customer,$store,'Pending Invoice Payment',$message,'Pay Now',$actionLink));

            return $this->sendResponse([
                'redirectTo'=>url()->previous()
            ],'Reminder successfully sent to customer.');

        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' while notifying customer: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
    //print invoice
    public function printInvoice($id)
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }

        $invoice = UserStoreInvoice::where('store',$store->id)->where('reference',$id)->firstOrFail();


        return view('dashboard.users.stores.components.invoices.print_page')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Print Invoice',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'invoice'       =>$invoice,
            'customer'      =>UserStoreCustomer::where('id',$invoice->customer)->first(),
            'fiat'          =>Fiat::where('code',$invoice->currency)->orWhere('code','USD')->first()
        ]);
    }
}
