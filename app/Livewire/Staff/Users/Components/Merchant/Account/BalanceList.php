<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Account;

use App\Models\AccountFunding;
use App\Models\Fiat;
use App\Models\SystemStaffAction;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserWithdrawal;
use App\Notifications\CustomNotificationNoLink;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class BalanceList extends Component
{
    use LivewireAlert,Helpers,WithPagination;
    public $staff;
    public $userId;
    public $user;
    public $currency;
    #[Url]
    public $withdrawalSearch='';
    #[Url]
    public $withdrawalStatus='all';
    #[Url]
    public $transactionSearch='';
    #[Url]
    public $transactionStatus='all';
    public $showAddBalance=false;
    public $showSubBalance=false;
    public $showAddRefBalance=false;
    public $showSubRefBalance=false;

    public $accountPin;
    public $notifyUser;
    public $amount;

    protected $listeners = [
        'balanceUpdated' => 'render',
    ];

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::where('reference', $this->userId)->first();
        $this->staff = Auth::guard('staff')->user();
        $this->currency = Fiat::where('code',$this->user->mainCurrency)->first();
    }
    //toggle add Balance
    public function toggleAddBalance()
    {
        $this->showAddBalance = !$this->showAddBalance;
        if ($this->showAddRefBalance){
            $this->showAddRefBalance=false;
        }
        if ($this->showSubBalance){
            $this->showSubBalance=false;
        }
        if ($this->showSubRefBalance){
            $this->showSubRefBalance=false;
        }
    }
    //toggle sub Balance
    public function toggleSubBalance()
    {
        $this->showSubBalance = !$this->showSubBalance;
        if ($this->showAddRefBalance){
            $this->showAddRefBalance=false;
        }
        if ($this->showAddBalance){
            $this->showAddBalance=false;
        }
        if ($this->showSubRefBalance){
            $this->showSubRefBalance=false;
        }
    }
    //toggle add ref Balance
    public function toggleAddRefBalance()
    {
        $this->showAddRefBalance = !$this->showAddRefBalance;
        if ($this->showAddBalance){
            $this->showAddBalance=false;
        }
        if ($this->showSubBalance){
            $this->showSubBalance=false;
        }
        if ($this->showSubRefBalance){
            $this->showSubRefBalance=false;
        }
    }
    //toggle sub ref Balance
    public function toggleSubRefBalance()
    {
        $this->showSubRefBalance = !$this->showSubRefBalance;
        if ($this->showAddRefBalance){
            $this->showAddRefBalance=false;
        }
        if ($this->showAddBalance){
            $this->showAddBalance=false;
        }
        if ($this->showSubBalance){
            $this->showSubBalance=false;
        }
    }
    //submit add balance
    public function submitAddBalance(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('create AccountFunding') && $staff->cannot('update UserBalance')) {

            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to perform this action',
                'width' => '400',
            ]);
            return;
        }
        $this->validate([
            'accountPin' =>'required|string|max:6|min:6',
            'notifyUser'=>['nullable'],
            'amount'=>['required','numeric']
        ]);

        try {
            $hashed = Hash::check($this->accountPin,$staff->accountPin);
            if (!$hashed){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Access Denied. Wrong authorization pin',
                    'width' => '400',
                ]);
                return;
            }
            //begin transaction
            DB::beginTransaction();

            $merchant = User::where('reference', $this->userId)->first();
            $fundingRef = $this->generateUniqueReference('account_fundings','reference');
            $transRef = $this->generateUniqueReference('transactions','reference');

            //top-up the balance
            $newBalance = bcadd( $merchant->accountBalance,$this->amount,5);
            $merchant->accountBalance =bcadd( $merchant->accountBalance,$this->amount,5);

            //create the entry
            $funding = AccountFunding::create([
                'user'=>$merchant->id,'reference' => $fundingRef,'amount' => $this->amount,
                'currency' => $merchant->mainCurrency,'charge' => 0,'amountCredit' => $this->amount,
                'transactionReference' => $transRef,'paymentReference' => $fundingRef,'status' => 1
            ]);

            $transaction = Transaction::create([
                'user'=>$merchant->id,'reference' => $transRef,'transactionType' =>6,
                'amount' => $this->amount,'currency' => $merchant->mainCurrency,
                'newBalance' =>$newBalance,'status' => 1
            ]);

            SystemStaffAction::create([
                'staff' => $staff->id,
                'action' => 'Topped-up Merchant Balance',
                'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                'model' => get_class($this->user).' / '.get_class($transaction).'/'.get_class($funding),
                'model_id' => $this->user->id,
            ]);
            $merchant->save();
            DB::commit();

            if (!empty($funding) && !empty($transaction)){
                if ($this->notifyUser){
                    $message = "
                        Your account has been credited with ".$merchant->mainCurrency.number_format($this->amount).".
                    ";
                    scheduleUserNotification($merchant->id,'Credit Notification'," Your account has been credited with ".$merchant->mainCurrency.number_format($this->amount).".");
                    $merchant->notify(new CustomNotificationNoLink($merchant->name,'Credit Notification',$message));
                }
                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Merchant account balance successfully funded',
                    'width' => '400',
                ]);
                $this->dispatch('balanceUpdated');
                $this->showAddBalance=false;
                $this->showSubBalance=false;
                $this->showAddRefBalance=false;
                $this->showSubRefBalance=false;
                $this->reset(['amount','accountPin']);
                return;
            }
        }catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while topping up merchant balance.',
                'width' => '400',
            ]);
            Log::error('Error funding merchant balance: ' . $e->getMessage());
        }
    }
    //submit sub balance
    public function submitSubBalance(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('create AccountFunding') && $staff->cannot('update UserBalance')) {

            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to perform this action',
                'width' => '400',
            ]);
            return;
        }
        $this->validate([
            'accountPin' =>'required|string|max:6|min:6',
            'notifyUser'=>['nullable'],
            'amount'=>['required','numeric']
        ]);

        try {
            $hashed = Hash::check($this->accountPin,$staff->accountPin);
            if (!$hashed){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Access Denied. Wrong authorization pin',
                    'width' => '400',
                ]);
                return;
            }
            //begin transaction
            DB::beginTransaction();

            $merchant = User::where('reference', $this->userId)->first();

            $newBalance = bcsub( $merchant->accountBalance,$this->amount,5);

            if ($newBalance <0){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Account balance after debit is less than zero.',
                    'width' => '400',
                ]);
                return;
            }
            //debit the balance
            $merchant->accountBalance =bcsub( $merchant->accountBalance,$this->amount,5);
            $merchant->save();
            SystemStaffAction::create([
                'staff' => $staff->id,
                'action' => 'Debited Merchant Balance',
                'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                'model' => get_class($this->user),
                'model_id' => $this->user->id,
            ]);
            DB::commit();

            if ($this->notifyUser){
                $message = "
                        Your account has been debited with ".$merchant->mainCurrency.number_format($this->amount).".
                    ";
                scheduleUserNotification($merchant->id,'Debit Notification'," Your account has been debited with ".$merchant->mainCurrency.number_format($this->amount).".");
                $merchant->notify(new CustomNotificationNoLink($merchant->name,'Debit Notification',$message));
            }
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Merchant account balance successfully debited',
                'width' => '400',
            ]);
            $this->dispatch('balanceUpdated');
            $this->showAddBalance=false;
            $this->showSubBalance=false;
            $this->showAddRefBalance=false;
            $this->showSubRefBalance=false;
            $this->reset(['accountPin','amount']);
            return;
        }catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while debiting merchant balance.',
                'width' => '400',
            ]);
            Log::error('Error debiting merchant balance: ' . $e->getMessage());
        }
    }
    //submit add referral balance
    public function submitAddRefBalance(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('create AccountFunding') && $staff->cannot('update UserBalance')) {

            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to perform this action',
                'width' => '400',
            ]);
            return;
        }
        $this->validate([
            'accountPin' =>'required|string|max:6|min:6',
            'notifyUser'=>['nullable'],
            'amount'=>['required','numeric']
        ]);

        try {
            $hashed = Hash::check($this->accountPin,$staff->accountPin);
            if (!$hashed){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Access Denied. Wrong authorization pin',
                    'width' => '400',
                ]);
                return;
            }
            //begin transaction
            DB::beginTransaction();

            $merchant = User::where('reference', $this->userId)->first();
            $fundingRef = $this->generateUniqueReference('account_fundings','reference');
            $transRef = $this->generateUniqueReference('transactions','reference');

            //top-up the balance
            $newBalance = bcadd( $merchant->referralBalance,$this->amount,5);
            $merchant->referralBalance =bcadd( $merchant->referralBalance,$this->amount,5);

            //create the entry
            $funding = AccountFunding::create([
                'user'=>$merchant->id,'reference' => $fundingRef,'amount' => $this->amount,
                'currency' => $merchant->mainCurrency,'charge' => 0,'amountCredit' => $this->amount,
                'transactionReference' => $transRef,'paymentReference' => $fundingRef,'status' => 1
            ]);

            $transaction = Transaction::create([
                'user'=>$merchant->id,'reference' => $transRef,'transactionType' =>7,
                'amount' => $this->amount,'currency' => $merchant->mainCurrency,
                'newBalance' =>$newBalance,'status' => 1
            ]);

            SystemStaffAction::create([
                'staff' => $staff->id,
                'action' => 'Topped-up Merchant Referral Balance',
                'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                'model' => get_class($this->user).' / '.get_class($transaction).'/'.get_class($funding),
                'model_id' => $this->user->id,
            ]);
            $merchant->save();
            DB::commit();

            if (!empty($funding) && !empty($transaction)){
                if ($this->notifyUser){
                    $message = "
                        Your account has been credited with a referral earning of ".$merchant->mainCurrency.number_format($this->amount).".
                    ";
                    scheduleUserNotification($merchant->id,'Referral Earning',"Your account has been credited with a referral earning of ".$merchant->mainCurrency.number_format($this->amount).".");
                    $merchant->notify(new CustomNotificationNoLink($merchant->name,'Referral Earning',$message));
                }
                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Merchant account balance successfully funded',
                    'width' => '400',
                ]);
                $this->dispatch('balanceUpdated');
                $this->showAddBalance=false;
                $this->showSubBalance=false;
                $this->showAddRefBalance=false;
                $this->showSubRefBalance=false;
                $this->reset(['amount','accountPin']);
                return;
            }
        }catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while topping up merchant referral balance.',
                'width' => '400',
            ]);
            Log::error('Error funding merchant referral balance: ' . $e->getMessage());
        }
    }
    //submit sub referral balance
    public function submitSubRefBalance(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('create AccountFunding') && $staff->cannot('update UserBalance')) {

            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to perform this action',
                'width' => '400',
            ]);
            return;
        }
        $this->validate([
            'accountPin' =>'required|string|max:6|min:6',
            'notifyUser'=>['nullable'],
            'amount'=>['required','numeric']
        ]);

        try {
            $hashed = Hash::check($this->accountPin,$staff->accountPin);
            if (!$hashed){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Access Denied. Wrong authorization pin',
                    'width' => '400',
                ]);
                return;
            }
            //begin transaction
            DB::beginTransaction();

            $merchant = User::where('reference', $this->userId)->first();

            $newBalance = bcsub( $merchant->referralBalance,$this->amount,5);

            if ($newBalance <0){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Referral balance after debit is less than zero.',
                    'width' => '400',
                ]);
                return;
            }
            //debit the balance
            $merchant->referralBalance =bcsub( $merchant->referralBalance,$this->amount,5);
            $merchant->save();
            SystemStaffAction::create([
                'staff' => $staff->id,
                'action' => 'Debited Merchant Referral Balance',
                'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                'model' => get_class($this->user),
                'model_id' => $this->user->id,
            ]);
            DB::commit();

            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Merchant referral balance successfully debited',
                'width' => '400',
            ]);
            $this->dispatch('balanceUpdated');
            $this->showAddBalance=false;
            $this->showSubBalance=false;
            $this->showAddRefBalance=false;
            $this->showSubRefBalance=false;
            $this->reset(['accountPin','amount']);
            return;
        }catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while debiting merchant referral balance.',
                'width' => '400',
            ]);
            Log::error('Error debiting merchant referral balance: ' . $e->getMessage());
        }
    }
    //render page
    public function render()
    {
        $withdrawal = UserWithdrawal::query()->where('user',$this->user->id)
            ->when($this->withdrawalSearch, function($query) {
                $query->where('reference', 'like', '%' . $this->withdrawalSearch . '%');
            })
            ->when($this->withdrawalStatus != 'all', function($query) {
                $query->where('status', $this->withdrawalStatus);
            })->latest()
            ->paginate(10,'*','payouts');

        //fetch all transactions
        $transaction = Transaction::query()->where('user',$this->user->id)
            ->when($this->transactionSearch, function($query) {
                $query->where('reference', 'like', '%' . $this->transactionSearch . '%');
            })
            ->when($this->transactionStatus != 'all', function($query) {
                $query->where('status', $this->transactionStatus);
            })->latest()
            ->paginate(10,'*','transactions');

        return view('livewire.staff.users.components.merchant.account.balance-list',[
            'withdrawals'=>$withdrawal,
            'transactions'=>$transaction
        ]);
    }
}
