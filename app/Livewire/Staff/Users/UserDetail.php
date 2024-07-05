<?php

namespace App\Livewire\Staff\Users;

use App\Models\User;
use Livewire\Component;

class UserDetail extends Component
{
    public $userId;
    public $user;

    public function mount($userId){
        $this->userId = $userId;
        $this->user = User::where('reference', $this->userId)->first();
    }

    public function render()
    {
        return view('livewire.staff.users.user-detail');
    }
}
