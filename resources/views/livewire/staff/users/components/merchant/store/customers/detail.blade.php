<div>
    @inject('injected','App\Custom\Regular')

    <div class="col-md-10 mx-auto mb-3">
        <div class="card radius-10">
            <div class="card-content">
                <div class="row">
                    <div class="col-md-3 col-6 mt-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 fw-bolder">Customer Name</p>
                                    <p class="mb-0" style="word-break: break-word;">
                                        {{$customer->name}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mt-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 fw-bolder">Customer Email</p>
                                    <p class="mb-0" style="word-break: break-word;">
                                        {{$customer->email}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mt-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 fw-bolder">Customer Phone</p>
                                    <p class="mb-0">
                                        {{$customer->phone}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mt-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 fw-bolder">Customer Id</p>
                                    <p class="mb-0" style="word-break: break-word;">
                                        {{ucfirst($customer->reference)}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>

        </div>
    </div>

    <div class="col-md-10 mx-auto mb-3">
        <div class="card radius-10">
            <div class="card-content">
                <div class="row">
                    <div class="col-md-3 col-6 mt-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 fw-bolder">Country</p>
                                    <p class="mb-0" style="word-break: break-word;">
                                        {{$customer->country??'N/A'}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mt-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 fw-bolder">State</p>
                                    <p class="mb-0" style="word-break: break-word;">
                                        {{$customer->state??'N/A'}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mt-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 fw-bolder">City</p>
                                    <p class="mb-0" style="word-break: break-word;">
                                        {{$customer->city??'N/A'}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mt-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 fw-bolder">Address</p>
                                    <p class="mb-0" style="word-break: break-word;">
                                        {{$customer->address??'N/A'}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6 mt-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 fw-bolder">Subscribed To Newsletter</p>
                                    <p class="mb-0" style="word-break: break-word;">
                                        @switch($customer->subscribedToNewletter)
                                            @case(1)
                                                <span class="text-success"
                                                      data-bs-toggle="tooltip"
                                                      title="Subscribed">
                                                    <i class="ri-checkbox-circle-fill"></i>
                                                </span>
                                                @break
                                            @default
                                                <span class="text-danger"
                                                      data-bs-toggle="tooltip"
                                                      title="Unsubscribed">
                                                    <i class="bx bxs-x-square"></i>
                                                </span>
                                                @break
                                        @endswitch
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mt-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 fw-bolder">Status</p>
                                    <p class="mb-0" style="word-break: break-word;">
                                        @switch($customer->status)
                                            @case(1)
                                                <span class="text-success"
                                                      data-bs-toggle="tooltip"
                                                      title="Active">
                                                    <i class="ri-checkbox-circle-fill"></i>
                                                </span>
                                                @break
                                            @default
                                                <span class="text-danger"
                                                      data-bs-toggle="tooltip"
                                                      title="Deactivated">
                                                    <i class="bx bxs-x-square"></i>
                                                </span>
                                                @break
                                        @endswitch
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>

        </div>
    </div>


    <div class="row gy-4">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        Orders
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <span>Show</span>
                            <select class="form-select form-select-sm w-auto" wire:model.live="orderShow">
                                <option>10</option>
                                <option>20</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                        </div>
                        <div class="icon-field">
                            <input type="text" wire:model.live="orderSearch" class="form-control form-control-sm w-auto" placeholder="Search">
                            <span class="icon">
                              <iconify-icon icon="ion:search-outline"></iconify-icon>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <select class="form-select form-select-sm w-auto" wire:model.live="orderStatus">
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
                                <th scope="col"> S/L</th>
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
                                        {{$orders->firstItem()+$index}}
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
                                            @default
                                                <span class="badge bg-dark">Payment Received - Processing & In Escrow</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        @empty($order->paymentMethod)
                                            Whatsapp

                                        @else
                                            {{$order->paymentMethod}}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                       <a href="{{route('staff.orders.detail',['id'=>$order->reference])}}" wire:navigate>
                                           <i class="ri-eye-line"></i>
                                       </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{$orders->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4 mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        Invoices
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <span>Show</span>
                            <select class="form-select form-select-sm w-auto" wire:model.live="invoiceShow">
                                <option>10</option>
                                <option>20</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                        </div>
                        <div class="icon-field">
                            <input type="text" wire:model.live="invoiceSearch" class="form-control form-control-sm w-auto" placeholder="Search">
                            <span class="icon">
                              <iconify-icon icon="ion:search-outline"></iconify-icon>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <select class="form-select form-select-sm w-auto" wire:model.live="invoiceStatus">
                            <option value="all">All</option>
                            <option value="1">Paid</option>
                            <option value="2">Pending</option>
                            <option value="3">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table bordered-table mb-0">
                            <thead>
                            <tr>
                                <th scope="col"> S/L</th>
                                <th scope="col">TITLE</th>
                                <th scope="col">REFERENCE</th>
                                <th scope="col">AMOUNT</th>
                                <th scope="col">DATE</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $key=> $invoice)
                                <tr>
                                    <td>
                                        {{$invoices->firstItem()+$key}}
                                    </td>
                                    <td>
                                        {{$invoice->title}}
                                    </td>
                                    <td>
                                        {{$invoice->reference}}
                                    </td>
                                    <td class="bold">
                                        {{$injected->fetchCurrencySign($invoice->currency)->currency_symbol}} {{$injected->formatNumber($invoice->amount)}}
                                    </td>
                                    <td>
                                        {{date('d M, Y - h:i A', strtotime($invoice->created_at))}}
                                    </td>
                                    <td class="bold">
                                        @switch($invoice->status)
                                            @case(1)
                                                <span class="badge bg-success">Paid</span>
                                                @break
                                            @case(2)
                                                <span class="badge bg-info">Pending Payment</span>
                                                @break
                                            @default
                                                <span class="badge bg-danger">Payment Cancelled</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        <a href="{{route('user.stores.invoices.details',['id'=>$invoice->reference])}}"
                                           wire:navigate>
                                            <i class="ri-eye-line"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{$invoices->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
