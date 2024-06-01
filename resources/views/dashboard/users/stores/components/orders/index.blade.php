@extends('dashboard.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')

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

@endsection
