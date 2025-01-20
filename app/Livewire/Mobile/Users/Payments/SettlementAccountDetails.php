<?php

namespace App\Livewire\Mobile\Users\Payments;

use App\Models\UserBank;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SettlementAccountDetails extends Component
{
    public $bank;
    public $user;

    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    public function mount(UserBank $bank)
    {
        $this->bank = $bank;
        $this->user = Auth::user();
    }
    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <!-- Loading spinner... -->
           <svg width="100%" height="100%" viewBox="0 0 400 130" preserveAspectRatio="none">
            <defs>
                <linearGradient id="skeleton-gradient">
                    <stop offset="0%" stop-color="#f0f0f0">
                        <animate attributeName="offset" values="-2; 1" dur="1.5s" repeatCount="indefinite" />
                    </stop>
                    <stop offset="50%" stop-color="#e0e0e0">
                        <animate attributeName="offset" values="-1.5; 1.5" dur="1.5s" repeatCount="indefinite" />
                    </stop>
                    <stop offset="100%" stop-color="#f0f0f0">
                        <animate attributeName="offset" values="-1; 2" dur="1.5s" repeatCount="indefinite" />
                    </stop>
                </linearGradient>
            </defs>

                <!-- Rectangle Placeholder -->
                <rect x="10" y="10" rx="5" ry="5" width="380" height="20" fill="url(#skeleton-gradient)" />

                <!-- Line Placeholder -->
                <rect x="10" y="40" rx="5" ry="5" width="350" height="15" fill="url(#skeleton-gradient)" />
                <rect x="10" y="65" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="10" y="90" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />


            </svg>
        </div>
        HTML;
    }
    public function render()
    {
        return view('livewire.mobile.users.payments.settlement-account-details',[
            'bank' => $this->bank
        ]);
    }
}
