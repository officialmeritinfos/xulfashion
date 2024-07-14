<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Ads;

use App\Models\User;
use App\Models\UserAd;
use App\Models\UserAdPhoto;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class AdDetail extends Component
{
    use WithPagination, LivewireAlert;

    public $user;
    public $userId;
    public $adId;
    public $ad;
    public $adImages;

    public function mount($userId,$adId)
    {
        $this->userId = $userId;
        $this->user = User::where('reference', $this->userId)->first();
        $this->adId = $adId;

        $this->ad = UserAd::where([
            'user'=>$this->user->id,'id'=>$this->adId
        ])->first();
        $this->adImages = UserAdPhoto::where('ad',$this->ad->id)->get();

    }

    public function render()
    {
        return view('livewire.staff.users.components.merchant.ads.ad-detail');
    }
}
