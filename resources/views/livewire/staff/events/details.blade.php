<div>
    @inject('option','App\Custom\Regular')
    @push('css')
        <style>
            .stats-panel {
                background-color: #ffeae2;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 20px;
            }
            .stat-item {
                text-align: center;
            }
            .stat-item h5 {
                color: #f24884;
                font-size: 20px;
                margin-bottom: 5px;
            }
            .stat-item p {
                color: #666;
                font-size: 14px;
            }
        </style>
    @endpush

        @if($staff->can('update UserAd'))
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
                        <button type="button" wire:click="toggleShowApproveForm" class="btn btn-sm btn-primary-600 radius-8 d-inline-flex align-items-center gap-1">
                            <iconify-icon icon="pepicons-pencil:paper-plane" class="text-xl"></iconify-icon>
                            <span>
                                Approve Event
                                <div wire:loading>
                                    <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                </div>
                            </span>
                        </button>
                        <button type="button" wire:click="toggleShowRejectForm" class="btn btn-sm btn-danger radius-8 d-inline-flex align-items-center gap-1">
                            <iconify-icon icon="solar:close-circle-outline" class="text-xl"></iconify-icon>
                            <span>
                                Reject Event
                                <div wire:loading>
                                    <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                </div>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    @if(!$showApproveForm && !$showRejectForm)

        <div class="row gy-4 mt-4 mb-5">
            <div class="col-lg-4">
                <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                    <img src="{{ asset('staff/images/user-grid/user-grid-bg1.png') }}" alt=""
                         class="w-100 object-fit-cover">
                    <div class="pb-24 ms-16 mb-24 me-16  mt--100">
                        <div class="text-center border border-top-0 border-start-0 border-end-0">
                            <img src="{{ $event->featuredImage??'https://ui-avatars.com/api/?rounded=true&name='.$event->title }}"
                                 alt=""
                                 class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover">
                            <h6 class="mb-0 mt-16">{{ $event->title }}</h6>
                            <div class="accordion mt-3" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Description
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <span class="text-secondary-light mb-16">{!! $event->description !!}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-24">
                            <h6 class="text-xl mb-16">Information</h6>
                            <ul>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Type of Event</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{eventType($event->eventType)}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Start Date & Time</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$event->startDate}} {{$event->startTime}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">End Time</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                            {{eventEndTime($event)}}
                                            </span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Schedule Type</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                            @if($event->eventScheduleType==1)
                                            One-time Event
                                        @else
                                            Recurring Event
                                        @endif
                                            </span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Timezone</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                                 {{$event->eventTimeZone}}
                                            </span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Platform/Venue</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                                 {{($event->eventType==1)?$event->location:$event->platform}}
                                            </span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">State/Link</span>
                                    <span class="w-70 text-secondary-light fw-medium">:

                                                @if($event->eventType==1)
                                            {{getStateFromIso2($event->state,$country->iso2)->name}}, {{$country->name}}
                                        @else
                                            {{$event->link}}
                                        @endif
                                            </span>
                                </li>
                                @if($event->scheduleType=2 && $event->recurrenceEndType==2)

                                    <li class="d-flex align-items-center gap-1 mb-12">
                                                <span class="w-30 text-md fw-semibold text-primary-light" style="word-break: break-word;">
                                                    Current Count:Recurrence Number
                                                </span>
                                        <span class="w-70 text-secondary-light fw-medium">:
                                                 {{$event->currentRecurring}}:{{$event->recurrenceEndCount}}
                                            </span>
                                    </li>
                                @endif
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Status</span>
                                    <span class="w-70 text-secondary-light fw-medium">
                                        :
                                        @switch($event->status)
                                            @case(1)
                                                <i class="fa fa-check-circle text-success" style="font-size: 14px;"
                                                   data-bs-toggle="tooltip" title="Active"></i>
                                                @break
                                            @case(2)
                                                <i class="fa fa-rotate-270 fa-rotate text-primary" style="font-size: 14px;"
                                                   data-bs-toggle="tooltip" title="Review"></i>
                                                @break
                                            @case(3)
                                                <i class="fa fa-ban text-danger" style="font-size: 14px;"
                                                   data-bs-toggle="tooltip" title="Cancelled"></i>
                                                @break
                                            @default
                                                <i class="fa fa-warning text-danger" style="font-size: 14px;"
                                                   data-bs-toggle="tooltip" title="Rejected"></i>
                                                @break
                                        @endswitch
                                    </span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <p class="text-sm mb-0"><span class="text-primary-light fw-semibold">Approved/Rejected By:</span>
                                        {{$option->fetchStaffById($event->approvedBy)->name??'N/A'}}</p>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="stats-panel d-flex justify-content-around align-items-center row mb-3">
                    <div class="stat-item col-6 mt-3">
                        <h5>{{shorten_number($ticketSold,0)}}</h5>
                        <p>Tickets sold</p>
                    </div>
                    <div class="stat-item col-6 mt-3" data-bs-toggle="tooltip" title="{{$event->totalSales}}">
                        <h5>{{currencySign($user->mainCurrency)}}{{shorten_number($event->totalSales,2)}}</h5>
                        <p>Total Sales revenue</p>
                    </div>
                    <div class="stat-item col-6 mt-3" data-bs-toggle="tooltip" title="{{$event->currentBalance}}">
                        <h5>{{currencySign($user->mainCurrency)}}{{shorten_number($event->currentBalance,2)}}</h5>
                        <p>Current Balance</p>
                    </div>
                    <div class="stat-item col-6 mt-3" data-bs-toggle="tooltip" title="{{$event->balanceCleared}}">
                        <h5>{{currencySign($user->mainCurrency)}}{{shorten_number($event->balanceCleared,2)}}</h5>
                        <p>Balance Cleared</p>
                    </div>
                    <div class="stat-item col-6 mt-3">
                        @if($event->currentBalance >0)
                            <h5>
                                {{date('d M, Y H:i',$event->nextSettlement)}}
                            </h5>
                        @else
                            <h5>-</h5>
                        @endif
                        <p>Next payout date</p>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="p-2 text-center mt-3">
                        <h6>Tickets</h6>
                    </div>
                    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <span>Show</span>
                                <select class="form-select form-select-sm w-auto" wire:model.live="ticketShow">
                                    <option>5</option>
                                    <option>10</option>
                                    <option>20</option>
                                    <option>50</option>
                                    <option>100</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <select class="form-select form-select-sm w-auto" wire:model.live="ticketStatus">
                                <option value="all">All</option>
                                <option value="1">Active</option>
                                <option value="2">Sold Out</option>
                                <option value="3">Deactivated</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($tickets->isNotEmpty())

                            <div class="table-responsive">
                                <table class="table bordered-table mb-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">
                                            <div class="form-check style-check d-flex align-items-center">
                                                <label class="form-check-label" for="checkAll">
                                                    S.L
                                                </label>
                                            </div>
                                        </th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tickets as $index=>$ticket)
                                        <tr>
                                            <td>
                                                <div class="form-check style-check d-flex align-items-center">
                                                    <label class="form-check-label" for="check1">
                                                        {{$tickets->firstItem()+$index}}
                                                    </label>
                                                </div>
                                            </td>
                                            <td>{{ucfirst($ticket->ticketType)}}</td>
                                            <td>{{$ticket->name}}</td>
                                            <td>{{$ticket->ticketSold}} / {{($ticket->unlimited==1)?'Unlimited':$ticket->quantity}}</td>
                                            <td>
                                                @if($ticket->isFree())
                                                    Free
                                                @else
                                                    {{currencySign($ticket->currency)}}{{$ticket->price()}}
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{$tickets->links()}}
                                </div>
                            </div>
                        @else
                            <div class="row gy-4">
                                <div class="col-lg-12 col-sm-12">
                                    <div
                                        class="p-16 bg-info-50 radius-8 border-start-width-3-px border-info border-top-0 border-end-0 border-bottom-0">
                                        <h6 class="text-primary-light text-md mb-8 text-center">No Tickets found.</h6>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="p-2 text-center mt-3">
                        <h6>Sales</h6>
                    </div>
                    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <span>Show</span>
                                <select class="form-select form-select-sm w-auto" wire:model.live="purchaseShow">
                                    <option>5</option>
                                    <option>10</option>
                                    <option>20</option>
                                    <option>50</option>
                                    <option>100</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <select class="form-select form-select-sm w-auto" wire:model.live="purchaseStatus">
                                <option value="all">All</option>
                                <option value="1">Completed</option>
                                <option value="2">Pending</option>
                                <option value="3">Cancelled</option>
                                <option value="4">Processing</option>
                                <option value="5">Cancelled By Compliance</option>
                                <option value="6">Failed</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($purchases->isNotEmpty())

                            <div class="table-responsive">
                                <table class="table bordered-table mb-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">
                                            <div class="form-check style-check d-flex align-items-center">
                                                <label class="form-check-label" for="checkAll">
                                                    S.L
                                                </label>
                                            </div>
                                        </th>
                                        <th scope="col">Ticket</th>
                                        <th scope="col">Buyer</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($purchases as $purchase)
                                        <tr>
                                            <td>
                                                <div class="form-check style-check d-flex align-items-center">
                                                    <label class="form-check-label" for="check1">
                                                        {{$tickets->firstItem()+1}}
                                                    </label>
                                                </div>
                                            </td>
                                            <td>{{$purchase->tickets->name}}</td>
                                            <td>
                                                {{$purchase->buyers->name}}
                                            </td>
                                            <td>{{$purchase->quantity}}</td>
                                            <td>
                                                @if($purchase->tickets->ticketType==1)
                                                    Single Ticket
                                                @else
                                                    Group Ticket
                                                @endif
                                            </td>
                                            <td>
                                                {{currencySign($purchase->purchaseCurrency)}}{{number_format($purchase->totalPrice,2)}}
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{$purchases->links()}}
                                </div>
                            </div>
                        @else
                            <div class="row gy-4">
                                <div class="col-lg-12 col-sm-12">
                                    <div
                                        class="p-16 bg-info-50 radius-8 border-start-width-3-px border-info border-top-0 border-end-0 border-bottom-0">
                                        <h6 class="text-primary-light text-md mb-8 text-center">No Sales found.</h6>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="p-2 text-center mt-3">
                        <h6>Payouts</h6>
                    </div>
                    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <span>Show</span>
                                <select class="form-select form-select-sm w-auto" wire:model.live="settlementShow">
                                    <option>5</option>
                                    <option>10</option>
                                    <option>20</option>
                                    <option>50</option>
                                    <option>100</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <select class="form-select form-select-sm w-auto" wire:model.live="settlementStatus">
                                <option value="all">All</option>
                                <option value="1">Completed</option>
                                <option value="2">Pending</option>
                                <option value="3">Cancelled</option>
                                <option value="4">Processing</option>
                                <option value="5">Cancelled By Compliance</option>
                                <option value="6">Failed</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($settlements->isNotEmpty())

                            <div class="table-responsive">
                                <table class="table bordered-table mb-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">
                                            <div class="form-check style-check d-flex align-items-center">
                                                <label class="form-check-label" for="checkAll">
                                                    S.L
                                                </label>
                                            </div>
                                        </th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Payout Account</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($settlements as $settlement)
                                        <tr>
                                            <td>
                                                <div class="form-check style-check d-flex align-items-center">
                                                    <label class="form-check-label" for="check1">
                                                        {{$tickets->firstItem()+1}}
                                                    </label>
                                                </div>
                                            </td>
                                            <td>{{$settlements->firstItem()+1}}</td>
                                            <td>
                                                {{$settlement->reference}}
                                            </td>
                                            <td>
                                                <span style="font-size: 12px;">{{$purchase->banks->accountName}} ({{$settlement->banks->bankName}}-{{$settlement->banks->accountNumber}})</span>
                                            </td>
                                            <td>
                                                {{currencySign($settlement->currency)}}{{number_format($settlement->amount,2)}}
                                            </td>
                                            <td>
                                                @switch($settlement->payoutStatus)
                                                    @case(1):
                                                    <span class="badge bg-success">Completed</span>
                                                    @break
                                                    @case(2):
                                                    <span class="badge bg-primary">Pending</span>
                                                    @break
                                                    @case(4):
                                                    <span class="badge bg-info">Processing</span>
                                                    @break
                                                    @case(3):
                                                    <span class="badge bg-warning">Cancelled</span>
                                                    @break
                                                    @case(5):
                                                    <span class="badge bg-warning">Cancelled By Compliance</span>
                                                    @break
                                                    @default
                                                        <span class="badge bg-danger">Failed</span>
                                                        @break
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{$tickets->links()}}
                                </div>
                            </div>
                        @else
                            <div class="row gy-4">
                                <div class="col-lg-12 col-sm-12">
                                    <div
                                        class="p-16 bg-info-50 radius-8 border-start-width-3-px border-info border-top-0 border-end-0 border-bottom-0">
                                        <h6 class="text-primary-light text-md mb-8 text-center">No Payouts found.</h6>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-body py-40">
            @if($showRejectForm)
                <form wire:submit.prevent="submitReject" class="row gy-3">
                    <p class="text-center text-danger">
                        You are about rejecting this Event.
                    </p>
                    <div class="col-md-12">
                        <label class="form-label">Reason<i class="text-danger">*</i> </label>
                        <textarea wire:model.live="rejectReason" class="form-control form-control-lg" rows="8"></textarea>
                        @error('rejectReason') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Authorization Pin<i class="text-danger">*</i></label>
                        <input type="password" wire:model.live="accountPin" class="form-control form-control-lg" minlength="6" maxlength="6">
                        @error('accountPin') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-12 text-center mt-3">
                        <button class="btn btn-outline-danger" type="submit">
                            <span>
                                Reject
                                <div wire:loading>
                                        <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                </div>
                            </span>
                        </button>
                    </div>
                </form>
            @endif
            @if($showApproveForm)
                <form wire:submit.prevent="submitApprove" class="row gy-3">
                    <p class="text-center text-success">
                        You are about approving this Event. Ensure it meets the standard.
                    </p>
                    <div class="col-md-12">
                        <label class="form-label">Authorization Pin<i class="text-danger">*</i></label>
                        <input type="password" wire:model.live="accountPin" class="form-control form-control-lg" minlength="6" maxlength="6">
                        @error('accountPin') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-12 text-center mt-3">
                        <button class="btn btn-outline-success" type="submit">
                            <span>
                                Approve
                                <div wire:loading>
                                        <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                </div>
                            </span>
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>


</div>
