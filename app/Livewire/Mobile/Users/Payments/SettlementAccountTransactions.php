<?php

namespace App\Livewire\Mobile\Users\Payments;

use App\Models\UserBank;
use App\Models\UserWithdrawal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class SettlementAccountTransactions extends Component
{
    use WithPagination;

    public $bankId;
    #[Url]
    public $search = '';
    #[Url]
    public $perPage = 5;

    public function mount($bankId)
    {
        $this->bankId = $bankId;
    }

    public function render()
    {
        $withdrawals = UserWithdrawal::where([
            'paymentDetails' => $this->bankId
        ])->when($this->search, function ($query, $search) {
                $query->where('reference', 'like', "%{$search}%");
            })->paginate($this->perPage);

        return view('livewire.mobile.users.payments.settlement-account-transactions', [
            'transactions' => $withdrawals,
            'bank' => UserBank::where('reference',$this->bankId)->first(),
        ]);
    }
}
