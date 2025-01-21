<div>
    @inject('option','App\Custom\Regular')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if($staff->can('update UserWithdrawal'))
                    <div class="card-header">
                        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
                            <a href="javascript:void(0)" class="btn btn-sm btn-success radius-8 d-inline-flex align-items-center gap-1"
                               wire:click="toggleApprovalForm">
                                <iconify-icon icon="solar:check-circle-linear" class="text-xl"></iconify-icon>
                                Approve Withdrawal
                            </a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger radius-8 d-inline-flex align-items-center gap-1"
                               wire:click="toggleCancelForm">
                                <iconify-icon icon="solar:close-circle-broken" class="text-xl"></iconify-icon>

                                Cancel Withdrawal
                            </a>
                        </div>
                    </div>
                @endif
                <div class="card-body py-40">
                    @if($showApproveForm)
                        <div class="row">
                            <div class="col-md-12 mx-auto">
                                <form wire:submit.prevent="submitApproval" class="row g-3">
                                    <div class="mb-2">
                                        <p class="text-center text-success">
                                            You are about approving this withdrawal. Ensure that the payout was successful before
                                            proceeding.
                                        </p>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label for="state" class="form-label">Authorization Pin</label>
                                        <input type="password" class="form-control" id="state" wire:model.live="accountPin" minlength="6" maxlength="6">
                                        @error('accountPin') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-12 mt-5 text-center">
                                        <button class="btn btn-outline-success text-sm btn-sm radius-8">
                                            <span>
                                                Approve Payout
                                                <div wire:loading>
                                                    <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                                </div>
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    @if($showCancelForm)
                        <div class="row">
                            <div class="col-md-12 mx-auto">
                                <form wire:submit.prevent="submitCancel" class="row g-3">
                                    <div class="mb-2">
                                        <p class="text-center text-warning">
                                            You are about cancelling this payout. This will issue an instant refund to the
                                        merchant's account.
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label for="state" class="form-label">Authorization Pin</label>
                                        <input type="password" class="form-control" id="state" wire:model.live="accountPin" maxlength="6" minlength="6">
                                        @error('accountPin') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <div class="form-switch switch-success d-flex align-items-center gap-3">
                                            <input class="form-check-input" type="checkbox" role="switch" id="switch3" wire:model.live="notifyUser">
                                            <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="switch3">Notify Merchant</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-5 text-center">
                                        <button class="btn btn-outline-warning text-sm btn-sm radius-8">
                                            <span>
                                                Cancel Payout
                                                <div wire:loading>
                                                    <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                                </div>
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if(!$showApproveForm && !$showCancelForm)
                        <div class="row justify-content-center" id="invoice">
                            <div class="col-lg-12">
                                <div class="shadow-4 border radius-8">
                                    <div class="p-20 d-flex flex-wrap justify-content-between gap-3 border-bottom">
                                        <div>
                                            <h3 class="text-xl">ID #{{$withdrawal->reference}}</h3>
                                            <p class="mb-1 text-sm">Date Issued: {{$withdrawal->created_at->format('d/m/Y h:i a')}}</p>
                                        </div>
                                    </div>
                                    <div class="py-28 px-20">
                                        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
                                           <div>
                                               <h6 class="text-md">Payout Account:</h6>
                                               <table class="text-sm text-secondary-light">
                                                   <tbody>
                                                   <tr>
                                                       <td>Bank</td>
                                                       <td class="ps-8">
                                                           {{empty($option->fetchPayoutAccountByReference($withdrawal->paymentDetails))?'N/A':$option->fetchPayoutAccountByReference($withdrawal->paymentDetails)->bankName}}
                                                       </td>
                                                   </tr>
                                                   <tr>
                                                       <td>Account Number</td>
                                                       <td class="ps-8">
                                                           {{empty($option->fetchPayoutAccountByReference($withdrawal->paymentDetails))?'N/A':$option->fetchPayoutAccountByReference($withdrawal->paymentDetails)->accountNumber}}
                                                       </td>
                                                   </tr>
                                                   <tr>
                                                       <td>Account Name</td>
                                                       <td class="ps-8">
                                                           {{empty($option->fetchPayoutAccountByReference($withdrawal->paymentDetails))?'N/A':$option->fetchPayoutAccountByReference($withdrawal->paymentDetails)->accountName}}
                                                       </td>
                                                   </tr>
                                                   </tbody>
                                               </table>
                                           </div>
                                            <div>
                                                <table class="text-sm text-secondary-light">
                                                    <tbody>
                                                    @if(!empty($option->fetchPayoutAccountByReference($withdrawal->paymentDetails)->meta) && json_decode($option->fetchPayoutAccountByReference($withdrawal->paymentDetails)->meta, true) !== [])
                                                        @php $metaData = json_decode($option->fetchPayoutAccountByReference($withdrawal->paymentDetails)->meta, true); @endphp
                                                        @foreach($metaData as $key => $value)
                                                            <tr>
                                                                <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                                                <td class="ps-8">
                                                                    {{ $value }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="mt-24">
                                            <div class="table-responsive scroll-sm">
                                                <table class="table bordered-table text-sm">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col" class="text-sm">Amount</th>
                                                        <th scope="col" class="text-sm">Amount To Credit</th>
                                                        <th scope="col" class="text-sm">Charge</th>
                                                        <th scope="col" class="text-sm">Status</th>
                                                        <th scope="col" class="text-end text-sm">
                                                            Approved/Cancelled By
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>{{$withdrawal->currency}}{{number_format($withdrawal->amount,2)}}</td>
                                                        <td>{{$withdrawal->currency}}{{number_format($withdrawal->amountCredit,2)}}</td>
                                                        <td>{{$withdrawal->currency}}{{number_format($withdrawal->amount-$withdrawal->amountCredit,2)}}</td>
                                                        <td>
                                                            @switch($withdrawal->status)
                                                                @case(1)
                                                                    <span class="badge bg-success">Completed</span>
                                                                    @break
                                                                @case(2)
                                                                    <span class="badge bg-primary">Pending</span>
                                                                    @break
                                                                @default
                                                                    <span class="badge bg-danger">Cancelled</span>
                                                                    @break
                                                            @endswitch
                                                        </td>
                                                        <td class="text-end">
                                                            {{empty($withdrawal->approvedBy)?'N/A':$option->fetchStaffById($withdrawal->approvedBy)->name}}
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex flex-wrap justify-content-between gap-3">

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                   @endif
                </div>
            </div>
        </div>
    </div>
</div>
