<?php

namespace App\Livewire\Staff\Verifications;

use App\Models\UserVerification;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Merchants extends Component
{
    use WithPagination;

    #[Url]
    public $search;
    #[Url]
    public $perPage = 10;

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <!-- Loading spinner... -->
           <svg width="100%" height="400px" viewBox="0 0 400 400" preserveAspectRatio="none">
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

                <!-- Card Placeholder 1 -->
                <rect x="10" y="10" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="25" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="55" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="75" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />

                <!-- Card Placeholder 2 -->
                <rect x="10" y="130" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="145" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="175" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="195" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />

                <!-- Card Placeholder 3 -->
                <rect x="10" y="250" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="265" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="295" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="315" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />
            </svg>
        </div>
        HTML;
    }
    public function render()
    {
        $verifications = UserVerification::when($this->search, function ($query) {
            $query->whereHas('users', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('username', 'like', '%' . $this->search . '%');
            });
        })->with(['users','docTypes'])->orderBy('created_at','desc')->paginate($this->perPage);


        return view('livewire.staff.verifications.merchants',[
            'verifications' => $verifications,
            'totalVerificationSubmissions' => UserVerification::count(),
            'pendingVerifications' => UserVerification::where('status',4)->count(),
            'completedVerifications' => UserVerification::where('status',1)->count(),
        ]);
    }
}
