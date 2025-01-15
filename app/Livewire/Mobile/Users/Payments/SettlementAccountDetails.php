<?php

namespace App\Livewire\Mobile\Users\Payments;

use App\Models\UserBank;
use Livewire\Component;

class SettlementAccountDetails extends Component
{
    public $bank;

    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    public function mount(UserBank $bank)
    {
        $this->bank = $bank;
    }
    public function render()
    {
        return view('livewire.mobile.users.payments.settlement-account-details',[
            'bank' => $this->bank
        ]);
    }
}
