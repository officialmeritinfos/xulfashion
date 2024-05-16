@extends('dashboard.layout.base')
@section('content')
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

    <div class="order-details-area mb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <form class="search-bar d-flex">
                        <i class="ri-search-line"></i>
                        <input class="form-control search" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </div>
            </div>

            <div class="latest-transaction-area">
                <div class="table-responsive" data-simplebar>
                    <table class="table align-middle mb-0">
                        <thead>
                        <tr>
                            <th scope="col">ORDER ID</th>
                            <th scope="col">CUSTOMER</th>
                            <th scope="col">DATE</th>
                            <th scope="col">TOTAL</th>
                            <th scope="col">STATUS</th>
                            <th scope="col">PAYMENT METHOD</th>
                            <th scope="col">ACTION</th>
                        </tr>
                        </thead>
                        <tbody class="searches">

                        @foreach($orders as $order)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox">
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
                                    {{$order->paymentMethod}}
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item" href="{{route('user.stores.orders.details',['id'=>$order->reference])}}">
                                                    Details
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
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

    <div class="order-details-area mb-0 mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <form class="search-bar d-flex">
                        <i class="ri-search-line"></i>
                        <input class="form-control search" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </div>

            </div>

            <div class="latest-transaction-area">
                <div class="table-responsive" data-simplebar>
                    <table class="table align-middle mb-0">
                        <thead>
                        <tr>
                            <th scope="col">TITLE</th>
                            <th scope="col">REFERENCE</th>
                            <th scope="col">AMOUNT</th>
                            <th scope="col">DATE</th>
                            <th scope="col">STATUS</th>
                            <th scope="col">ACTION</th>
                        </tr>
                        </thead>
                        <tbody class="searches">

                        @foreach($invoices as $invoice)
                            <tr>
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
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item" href="{{route('user.stores.invoices.details',['id'=>$invoice->reference])}}">
                                                    Details
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('user.stores.invoices.edit',['id'=>$invoice->reference])}}">
                                                    Edit
                                                    <i class="ri-edit-2-line"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{$invoices->links()}}
                </div>
            </div>
        </div>
    </div>

@endsection
