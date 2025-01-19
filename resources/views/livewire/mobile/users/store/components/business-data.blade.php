<div class="container-fluid py-3">

    <!-- Store Statistics -->
    <div class="row g-3">
        <div class="col-12">
            <div class="card shadow-sm border-0">

                <!-- Updated Card Header -->
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3 bg-dark text-white">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <h5 class="mb-0"><i class="fa fa-chart-bar me-2"></i> Store Statistics</h5>
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-3">

                        <a href="{{ route('merchant.store', ['subdomain' => $store->slug]) }}" target="_blank"  title="View Store">
                            <i class="fa fa-eye"></i>
                        </a>
                        <i class="fa fa-share-alt cpy"

                           data-clipboard-text="Check out {{$store->name}} on {{route('merchant.store', ['subdomain'=>$store->slug])}}"
                           title="Share Store Link"></i>

                        <div wire:loading wire:target="perPage, search" class="spinner-border text-light spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div class="">
                        <div class="row g-3 text-center">
                            @foreach([
                                ['Total Sales', $statistics['totalSales'], 'fa-shopping-cart', 'primary'],
                                ['Revenue', $statistics['totalRevenue'], 'fa-wallet', 'info'],
                                ['Customers', $statistics['totalCustomers'], 'fa-users', 'warning'],
                                ['Products', $statistics['totalProducts'], 'fa-box-open', 'danger'],
                                ['Invoice Revenue', $statistics['invoiceRevenue'], 'fa-file-invoice-dollar', 'success'],
                            ] as [$label, $value, $icon, $color])
                                <div class="col-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                            <div class="mb-2">
                                        <span class="badge bg-{{ $color }} rounded-circle p-3">
                                            <i class="fa {{ $icon }} fa-sm text-white"></i>
                                        </span>
                                            </div>
                                            <h5 class="fw-bold mb-1">{{ number_format($value) }}</h5>
                                            <small class="text-muted">{{ $label }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- Popular Products -->
        <div class="col-12">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Popular Products</h5>
                </div>
                <div class="card-body scrollable-table-container">
                    @if($popularProducts->count())
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Quantity Sold</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($popularProducts as $product)
                                <tr>
                                    <td>
                                        <img src="{{ $product['photo'] }}" alt="{{ $product['product'] }}" class="img-thumbnail" width="50">
                                    </td>
                                    <td>{{ $product['product'] }}</td>
                                    <td>{{ $product['quantity'] }}</td>
                                    <td>{{ $product['currency'] }}{{ number_format($product['amount'], 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted text-center">No popular products found.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="col-12">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-dark">
                    <h5 class="mb-0">Recent Orders</h5>
                </div>
                <div class="card-body scrollable-table-container">
                    @if($recentOrders->count())
                        <table class="table table-striped">
                            <thead >
                                <tr>
                                    <th>Reference</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td><span class="badge bg-primary">{{ $order->reference }}</span></td>
                                    <td>{{ $order->customers->name }}</td>
                                    <td>{{ $order->currency }}{{ number_format($order->amount, 2) }}</td>
                                    <td>{{ $order->created_at->format('d M, Y - h:i A') }}</td>
                                    <td>
                                        <a href="{{route('user.stores.orders.details',['id'=>$order->reference])}}"><i class="fa fa-arrow-circle-right"></i> </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted text-center">No recent orders available.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Invoices -->
        <div class="col-12">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-dark">
                    <h5 class="mb-0">Recent Invoices(Recent 10)</h5>
                </div>
                <div class="card-body scrollable-table-container">
                    @if($invoicePayments->count())
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoicePayments as $invoice)
                                <tr>
                                    <td><span class="badge bg-primary">{{ $invoice->reference }}</span></td>
                                    <td>{{ $invoice->customers->name }}</td>
                                    <td>{{ $invoice->currency }}{{ number_format($invoice->amount, 2) }}</td>
                                    <td>{{ $invoice->created_at->format('d M, Y - h:i A') }}</td>
                                    <td>
                                        <a href="{{route('user.stores.invoices.details',['id'=>$invoice->reference])}}"><i class="fa fa-arrow-circle-right"></i> </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted text-center">No Invoice has been paid recently</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
