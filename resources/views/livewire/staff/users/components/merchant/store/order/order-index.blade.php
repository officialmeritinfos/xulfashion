<div>
    @inject('injected','App\Custom\Regular')
    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <span>Show</span>
                    <select class="form-select form-select-sm w-auto" wire:model.live="show">
                        <option>5</option>
                        <option>10</option>
                        <option>15</option>
                        <option>20</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </div>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-3">
                <div class="icon-field">
                    <input type="text" name="#0" class="form-control form-control-sm w-auto" placeholder="Search" wire:model.live="search">
                    <span class="icon">
                          <iconify-icon icon="ion:search-outline"></iconify-icon>
                        </span>
                </div>
                <select class="form-select form-select-sm w-auto" wire:model.live="status">
                    <option value="all">All</option>
                    <option value="1">Completed</option>
                    <option value="2">Pending Payment</option>
                    <option value="3">Cancelled</option>
                    <option value="4">Processing</option>
                    <option value="5">Incomplete Payment</option>
                    <option value="6">In Escrow</option>
                </select>
            </div>
        </div>
        <div class="card-body">
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
                        <th scope="col">STORE</th>
                        <th scope="col">ORDER ID</th>
                        <th scope="col">CUSTOMER</th>
                        <th scope="col">DATE</th>
                        <th scope="col">TOTAL</th>
                        <th scope="col">STATUS</th>
                        <th scope="col">PAYMENT METHOD</th>
                        <th scope="col">ACTION</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $index=> $order)
                        <tr>
                            <td>
                                <div class="form-check style-check d-flex align-items-center">
                                    <label class="form-check-label" for="check1">
                                        {{$orders->firstItem()+$index}}
                                    </label>
                                </div>
                            </td>
                            <td>
                                {{$injected->fetchStoreById($order->store)->name??'N/A'}}
                            </td>
                            <td>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        {{$order->reference}}
                                    </label>
                                </div>
                            </td>
                            <td>
                                {{$injected->customerById($order->customer)->name}}
                            </td>
                            <td>
                                {{date('d M, Y - h:i A', strtotime($order->created_at))}}
                            </td>
                            <td class="bold">
                                {{$injected->fetchCurrencySign($order->currency)->currency_symbol}} {{number_format($order->amount,2)}}
                            </td>
                            <td class="bold">
                                @switch($order->status)
                                    @case(1)
                                        <span class="badge bg-success">Completed</span>
                                        @break
                                    @case(2)
                                        <span class="badge bg-info">Pending Payment</span>
                                        @break
                                    @case(3)
                                        <span class="badge bg-danger">Cancelled</span>
                                        @break
                                    @case(4)
                                        <span class="badge bg-primary">Payment Received - Processing</span>
                                        @break
                                    @case(5)
                                        <span class="badge bg-warning text-white">Incomplete Payment</span>
                                        @break
                                    @case(6)
                                        <span class="badge bg-dark">Payment Received - Processing & In Escrow</span>
                                        @break
                                    @default
                                        <span class="badge bg-dark">Payment Under Review - Please contact support</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                @if($order->checkoutType==1)
                                    <p class="inv-from-1">
                                        <span class="badge bg-dark">Completed On Whatsapp</span>
                                    </p>
                                @else
                                    <p class="inv-from-1">
                                        <span class="badge bg-dark">{{str_replace('_',' ',$order->paymentMethod)??'Online'}}</span>
                                    </p>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{route('staff.orders.detail',['id'=>$order->reference,'store'=>$injected->fetchStoreById($order->store)->reference])}}" wire:navigate>
                                    <i class="ri-eye-line"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{$orders->links()}}
            </div>
        </div>
    </div>

</div>
