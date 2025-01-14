<?php

namespace App\Livewire\Mobile\Users\Payments;

use App\Models\UserBank;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class BankLists extends Component
{
    use WithPagination;

    public $user;
    public $numberPerPage = 10;
    public $bankId;

    #[Url]
    public $search;

    public function mount($user)
    {
        $this->user = $user;
    }
    public function render()
    {
        $banks =  UserBank::where('user', $this->user->id)
            ->when($this->search, function ($query, $search) {
                $query->where('bankName', 'like', "%{$search}%")
                    ->orWhere('accountNumber', 'like', "%{$search}%")
                    ->orWhere('accountName', 'like', "%{$search}%");
            })
            ->orderBy('isPrimary','asc')
            ->paginate($this->numberPerPage);
        return view('livewire.mobile.users.payments.bank-lists',[
            'banks' => $banks,
        ]);
    }
}
