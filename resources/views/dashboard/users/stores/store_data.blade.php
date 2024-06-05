<div class="mt-3 row wallet-chart-area with-exchange" id="statistics">
    <!-- Statistics -->
    <div class="col-xl-12 mb-4 col-lg-12 col-12">
        <div class="card h-auto">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title mb-0">Statistics</h5>
                <h5 class="card-title mb-0">
                    <a href="{{route('merchant.store',['subdomain'=>$store->slug])}}" target="_blank"><i class="ri-eye-line" data-bs-toggle="tooltip" title="View Store"></i> </a>
                </h5>
                <h5 class="card-title mb-0">
                    <a class="cpy"
                       data-clipboard-text="Hey guys,checkout my new store: {{$store->name}} on {{$siteName}}  {{route('merchant.store',['subdomain'=>$store->slug])}}"
                    ><i class="ri-share-forward-2-fill" data-bs-toggle="tooltip" title="Share Store Link"></i> </a>
                </h5>
            </div>
            <hr style="margin-top: -0.5rem;"/>
            <div class="card-body g-5">
                <div class="row gy-3 justify-content-center">
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-primary me-3 p-2"><i class="ti ti-chart-pie-2 ti-sm"></i></div>
                            <div class="card-info">
                                <h5 class="mb-0">{{$injected->formatNumber($injected->numberOfSalesInStore($store->id))}}</h5>
                                <small>Total Sales<i class="ri-information-fill" data-bs-toggle="tooltip"
                                    title="Total number of orders received - which includes ony successfully processed orders where the status
                                    has updated to completed."></i> </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-success me-3 p-2"><i class="ti ti-currency-dollar ti-sm"></i></div>
                            <div class="card-info">
                                <h5 class="mb-0">{{$injected->fetchCurrencySign($store->currency)->currency_symbol}}{{$injected->formatNumber($injected->invoiceRevenueInStore($store->id))}} </h5>
                                <small>Invoice Revenue<i class="ri-information-fill" data-bs-toggle="tooltip"
                                                 title="Total sum of money earned through invoices. This only accounts for invoices whose payment was processed through
                                                 this platform not offline payments."></i></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-success me-3 p-2"><i class="ti ti-currency-dollar ti-sm"></i></div>
                            <div class="card-info">
                                <h5 class="mb-0">{{$injected->fetchCurrencySign($store->currency)->currency_symbol}}{{$injected->formatNumber($injected->revenueInStore($store->id))}} </h5>
                                <small>Revenue<i class="ri-information-fill" data-bs-toggle="tooltip"
                                                 title="Total sum of money earned through your stores. This only accounts for sales which was marked as completed."></i></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-info me-3 p-2"><i class="ti ti-users ti-sm"></i></div>
                            <div class="card-info">
                                <h5 class="mb-0">{{$injected->formatNumber($injected->numberOfCustomersInStore($store->id))}}</h5>
                                <small>Customers</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-danger me-3 p-2"><i class="ti ti-shopping-cart ti-sm"></i></div>
                            <div class="card-info">
                                <h5 class="mb-0">{{$injected->numberOfProductInStore($store->id)}}</h5>
                                <small>Products</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Statistics -->



    <!-- Popular Product -->
    <div class="col-md-6 col-xl-6 mb-4">
        <div class="card h-auto">
            <div class="card-title m-0 me-2">
                <h5 class="m-0 me-2">Popular Products</h5>
            </div>
            <hr/>
            <div class="card-body">
                <ul class="p-0 m-0">
                    @if(count($injected->mostOrderProducts($store->id)) >0)
                        @foreach($injected->mostOrderProducts($store->id) as $productData)
                            <li class="d-flex mb-4 pb-1">
                                <div class="me-3">
                                    <img src="{{$productData['photo']}}" alt="User" class="rounded" width="46">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">{{$productData['product']}}</h6>
                                        <small class="text-muted d-block">Quantity: {{$productData['quantity']}}</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <p class="mb-0 fw-medium">{{$productData['currency']}}{{number_format($productData['amount'])}}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <!--/ Popular Product -->

    <div class="col-xl-6">
        <div class="available-cards-wrap mb-5">

            <div class="recent-transaction-wrap">
                <div class="recent-title">
                    <h3>Recent Orders</h3>
                </div>

                <div class="shorting" data-simplebar>
                    <ul>
                        @if(count($injected->topSales($store->id))>0)
                            @foreach($injected->topSales($store->id) as $order)
                                <li class="mix buy">
                                    <h6>{{$order->reference}} <span class="buy"></span></h6>
                                    <p>{{$injected->customerById($order->customer)->name}}</p>
                                    <div class="balance">
                                        <h5>{{$injected->fetchCurrencySign($order->currency)->currency_symbol}} {{number_format($order->amount,2)}}</h5>
                                        <p>{{date('d M, Y - h:i A', strtotime($order->created_at))}}</p>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
