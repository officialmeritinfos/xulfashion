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
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Payouts extends Component
{
    use LivewireAlert,Helpers,WithPagination;
    public $staff;
    public $userId;
    public $user;
    public $withdrawalId;
    public $withdrawal;
    public $showCancelForm=false;
    public $showApproveForm=false;
    public $showMarkPaid=false;

    public $accountPin;
    public $notifyUser;
    public $paymentReference;

    protected $listeners = [
        'payoutUpdated' => 'render',
    ];

    public function mount($userId,$withdrawalId)
    {
        $this->userId = $userId;
        $this->withdrawalId = $withdrawalId;
        $this->user = User::where('reference', $this->userId)->first();
        $this->staff = Auth::guard('staff')->user();
        $this->currency = Fiat::where('code',$this->user->mainCurrency)->first();
        $this->withdrawal = UserWithdrawal::where([
            'user'=>$this->user->id,'reference' => $this->withdrawalId
        ])->first();
    }
    //toggle show approve form
    public function toggleApprovalForm()
    {
        $this->showApproveForm = !$this->showApproveForm;
        if ($this->showCancelForm){
            $this->showCancelForm=false;
        }
        if ($this->showMarkPaid){
            $this->showMarkPaid=false;
        }
    }
    //toggle show cancel form
    public function toggleCancelForm()
    {
        $this->showCancelForm = !$this->showCancelForm;
        if ($this->showApproveForm){
            $this->showApproveForm=false;
        }

        if ($this->showMarkPaid){
            $this->showMarkPaid=false;
        }
    }
    //toggle show cancel form
    public function toggleMarkPaidForm()
    {
        $this->showMarkPaid = !$this->showMarkPaid;
        if ($this->showApproveForm){
            $this->showApproveForm=false;
        }
        if ($this->showCancelForm){
            $this->showCancelForm=false;
        }
    }
    //submit approval form
    public function submitApproval()
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('update UserWithdrawal')) {

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

            $withdrawal = UserWithdrawal::where([
                'user'=>$this->user->id,
                'reference' => $this->withdrawal->reference
            ])->first();

            if (empty($withdrawal)){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Payout not found',
                    'width' => '400',
                ]);
                return;
            }
            if ($withdrawal->status==1){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Payout already approved',
                    'width' => '400',
                ]);
                return;
            }
            if ($withdrawal->status ==3){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Payout already cancelled.',
                    'width' => '400',
                ]);
                return;
            }
            $transaction = Transaction::where([
                'user'=>$this->user->id,
                'withdrawalRef' => $withdrawal->reference
            ])->first();

            $withdrawal->update([
                'status' => 4,
                'approvedBy' => $staff->id,
                'paymentStatus' => 4
            ]);

            $transaction->status=4;
            $transaction->save();

            $merchant = User::where('id',$this->user->id)->first();

            scheduleUserNotification($this->user->id,'Payout Processed',"Your payout has been sent and should arrive in your account soon.");

            $message = "
                Your payout has been successfully processed and is on its way. It should reflect in your account shortly,
                depending on your bank’s processing time. If you don’t see it within the expected timeframe, please check
                with your financial institution or reach out to our support team for assistance.
            ";

            $merchant->notify(new CustomNotificationNoLink($merchant->name,'Payout Successfully Processed',$message));

            SystemStaffAction::create([
                'staff' => $staff->id,
                'action' => 'Merchant Payout Approval',
                'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                'model' => get_class($this->user).' / '.get_class($transaction).'/'.get_class($withdrawal),
                'model_id' => $this->user->id,
            ]);

            DB::commit();

            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Merchant payout successfully approved.',
                'width' => '400',
            ]);
            $this->dispatch('payoutUpdated');
            $this->showApproveForm=false;
            $this->showCancelForm=false;
            $this->reset('accountPin');
            return;
        }catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while topping up merchant balance.',
                'width' => '400',
            ]);
            Log::error('Error approving merchant payout: ' . $e->getMessage());
        }
    }
    //submit cancellation form
    public function submitCancel()
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('update UserWithdrawal')) {

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

            $withdrawal = UserWithdrawal::where([
                'user'=>$this->user->id,
                'reference' => $this->withdrawal->reference
            ])->first();

            if (empty($withdrawal)){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Payout not found',
                    'width' => '400',
                ]);
                return;
            }
            if ($withdrawal->status==1){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Payout already approved',
                    'width' => '400',
                ]);
                return;
            }
            if ($withdrawal->status ==3){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Payout already cancelled.',
                    'width' => '400',
                ]);
                return;
            }
            $transaction = Transaction::where([
                'user'=>$this->user->id,
                'withdrawalRef' => $this->withdrawal->reference
            ])->first();

            $merchant = User::where('reference',$this->user->reference)->first();

            $newBalance = bcadd($merchant->accountBalance,$withdrawal->amount);
            $merchant->accountBalance = bcadd($merchant->accountBalance,$withdrawal->amount);

            $reference = $this->generateUniqueReference('transactions','reference');

            $newTransaction = Transaction::create([
                'amount' => $withdrawal->amount,'reference' => $reference,
                'transactionType' => 8, 'currency' => $withdrawal->currency,
                'newBalance' => $newBalance,'status' => 1,'user'=>$merchant->id
            ]);

            if (!empty($newTransaction)){
                $withdrawal->status=3;
                $withdrawal->approvedBy=$staff->id;
                $withdrawal->save();

                $transaction->status=3;
                $transaction->save();
                $merchant->save();

                if ($this->notifyUser){
                    $message = "
                        Your payout of ".$withdrawal->currency.number_format($withdrawal->amount,2)." failed, and the full
                        amount refunded back into your account balance.
                    ";

                    scheduleUserNotification($this->user->id,'Payout Failed'," Your payout of ".$withdrawal->currency.number_format($withdrawal->amount,2)." failed, and the full
                        amount refunded back into your account balance.");
                    $merchant->notify(new CustomNotificationNoLink($merchant->name,'Payout failed',$message));
                }


                SystemStaffAction::create([
                    'staff' => $staff->id,
                    'action' => 'Merchant Payout Cancellation',
                    'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                    'model' => get_class($this->user).' / '.get_class($transaction).'/'.get_class($withdrawal).'/'.get_class($newTransaction),
                    'model_id' => $this->user->id,
                ]);

                DB::commit();

                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Merchant payout successfully cancelled.',
                    'width' => '400',
                ]);
                $this->dispatch('payoutUpdated');
                $this->showApproveForm=false;
                $this->showCancelForm=false;
                $this->reset('accountPin');
                return;
            }
        }catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while cancelling payout.',
                'width' => '400',
            ]);
            Log::error('Error cancelling merchant payout: ' . $e->getMessage());
        }
    }
    //mark as paid
    public function markAsPaid()
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('update UserWithdrawal')) {

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
            'paymentReference'=>'required|string'
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

            $withdrawal = UserWithdrawal::where([
                'user'=>$this->user->id,
                'reference' => $this->withdrawal->reference
            ])->first();

            if (empty($withdrawal)){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Payout not found',
                    'width' => '400',
                ]);
                return;
            }
            if ($withdrawal->status==1){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Payout already approved',
                    'width' => '400',
                ]);
                return;
            }
            if ($withdrawal->status ==3){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Payout already cancelled.',
                    'width' => '400',
                ]);
                return;
            }
            if ($withdrawal->manualUpdate!=1){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Payout does not need manual review',
                    'width' => '400',
                ]);
                return;
            }
            $transaction = Transaction::where([
                'user'=>$this->user->id,
                'withdrawalRef' => $withdrawal->reference
            ])->first();

            $withdrawal->update([
                'status' => 1,
                'approvedBy' => $staff->id,
                'paymentStatus' => 1,
                'paymentReference' => $this->paymentReference
            ]);

            $transaction->status=1;
            $transaction->save();

            SystemStaffAction::create([
                'staff' => $staff->id,
                'action' => 'Merchant Payout Approval',
                'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                'model' => get_class($this->user).' / '.get_class($transaction).'/'.get_class($withdrawal),
                'model_id' => $this->user->id,
            ]);

            DB::commit();

            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Merchant payout successfully marked as paid.',
                'width' => '400',
            ]);
            $this->dispatch('payoutUpdated');
            $this->showApproveForm=false;
            $this->showCancelForm=false;
            $this->showMarkPaid=false;
            $this->reset('accountPin','paymentReference');
            return;
        }catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while marking payout as paid.',
                'width' => '400',
            ]);
            Log::error('Error marking merchant payout as paid: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.staff.users.components.merchant.account.payouts');
    }
}
