@extends('dashboard.layout.base')
@section('content')

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
                            <th scope="col">DATE</th>
                            <th scope="col">TOTAL</th>
                            <th scope="col">PAYMENT METHOD</th>
                            <th scope="col">STATUS</th>
                            <th scope="col">PAYMENT STATUS</th>
                            <th scope="col">ACTION</th>
                        </tr>
                        </thead>
                        <tbody class="searches">
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        {{$order->reference}}
                                    </td>
                                    <td>
                                        {{date('F d, Y',strtotime($order->created_at))}}
                                    </td>
                                    <td>
                                        {{$order->currency}}{{number_format($order->totalAmountToPay,2)}}
                                    </td>
                                    <td>
                                        {{ucfirst($order->paymentMethod)}}
                                    </td>
                                    <td>
                                        @switch($order->status)
                                            @case(1)
                                                <span class="badge bg-success">Completed</span>
                                            @break
                                            @case(2)
                                                <span class="badge bg-info">Pending Payment</span>
                                            @break
                                            @case(4)
                                                <span class="badge bg-dark">Processing Order</span>
                                            @break
                                            @default
                                                <span class="badge bg-success">Cancelled</span>
                                            @break
                                        @endswitch
                                    </td>
                                    <td>
                                        @switch($order->paymentStatus)
                                            @case(1)
                                                <span class="badge bg-success">Completed</span>
                                            @break
                                            @case(2)
                                                <span class="badge bg-info">Pending Payment</span>
                                            @break
                                            @case(4)
                                                <span class="badge bg-primary">Payment Received</span>
                                            @break
                                            @case(5)
                                                <span class="badge bg-dark">Partial Payment</span>
                                            @break
                                            @default
                                                <span class="badge bg-success">Cancelled</span>
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
                                                    <a class="dropdown-item" href="{{route('user.stores.orders.details',['id'=>$order->reference])}}">
                                                        View
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

@endsection
