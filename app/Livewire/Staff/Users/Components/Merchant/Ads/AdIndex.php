<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Ads;

use App\Models\User;
use App\Models\UserAd;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AdIndex extends Component
{
    use WithPagination, LivewireAlert;
    #[Url]
    public $search = '';
    #[Url]
    public $searchStatus = 'all';
    #[Url]
    public $show = 10;
    public $staff;

    public function mount()
    {
        $this->staff = Auth::guard('staff')->user();
    }

    public function render()
    {
        $ads = UserAd::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('reference', 'like', '%' . $this->search . '%');
            })
            ->when($this->searchStatus != 'all', function ($query) {
                $query->where('status', $this->searchStatus);
            })
            ->latest()
            ->paginate($this->show);

        return view('livewire.staff.users.components.merchant.ads.ad-index',[
            'ads'=>$ads
        ]);
    }
}
