<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Ads;

use App\Models\User;
use App\Models\UserAd;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

    protected $listeners = [
        'renderAds' => 'render',
        'deleteConfirmed'
    ];

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
    //delete ad
    public function deleteAd($id)
    {
        try {
            $ad = UserAd::where([
                'id' => $id,
            ])->first();

            //open a dialog to confirm action
            $this->alert('warning', '', [
                'text' => 'Do you want to delete ' . $ad->title,
                'showConfirmButton' => true,
                'confirmButtonText' => 'Yes',
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancel',
                'onConfirmed' => 'deleteConfirmed',
                'data' => [
                    'id' => $id
                ],
                'timer' => null
            ]);
        } catch (\Exception $exception) {
            Log::info('An error occurred while trying to delete an ad');
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while creating an ad for merchant',
                'width' => '400',
            ]);
            return;
        }
    }

    //delete confirmed
    public function deleteConfirmed($data)
    {
        $id = $data['id'] ?? null;

        if ($id) {
            $ad = UserAd::where([
                'id' => $id
            ])->first();

            if ($ad) {
                $ad->delete();
            }
        }

        $this->dispatch('renderAds');
    }
}
