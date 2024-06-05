<div class="today-card-area pt-24">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-3 col-sm-6">
                <div class="single-today-card d-flex align-items-center">
                    <div class="flex-grow-1">
                        <span class="today">Total Store Revenue<i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                  title="This only includes orders that have been processed - marked as completed.
                                                                  Amount credited if paid online may differ due to charges"></i></span>
                        <h6>{{$store->currency}} {{$injected->formatNumber($injected->fetchTotalRevenue($store),2)}}</h6>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <img src="{{asset('dashboard/images/icon/discount.png')}}" alt="Images">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single-today-card d-flex align-items-center">
                    <div class="flex-grow-1">
                        <span class="today">Total Order<i class="ri-information-fill" data-bs-toggle="tooltip"
                            title="This only includes orders that have been processed - marked as completed"></i> </span>
                        <h6>{{$injected->fetchTotalOrders($store)}}</h6>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <img src="{{asset('dashboard/images/icon/discount.png')}}" alt="Images">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single-today-card d-flex align-items-center">
                    <div class="flex-grow-1">
                        <span class="today">Today's Money</span>
                        <h6>{{$store->currency}} {{$injected->formatNumber($injected->fetchTodayMoney($store),2)}}</h6>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <img src="{{asset('dashboard/images/icon/discount.png')}}" alt="Images">
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="single-today-card d-flex align-items-center">
                    <div class="flex-grow-1">
                        <span class="today">Today's Order</span>
                        <h6>{{$injected->fetchTodayOrders($store)}}</h6>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <img src="{{asset('dashboard/images/icon/user.png')}}" alt="Images">
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="single-today-card d-flex align-items-center">
                    <div class="flex-grow-1">
                        <span class="today">New Customers</span>
                        <h6>{{$injected->fetchNewCustomers($store)}}</h6>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <img src="{{asset('dashboard/images/icon/groop.png')}}" alt="Images">
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="single-today-card d-flex align-items-center">
                    <div class="flex-grow-1">
                        <span class="today">Sales Of This Week</span>
                        <h6>{{$store->currency}} {{$injected->formatNumber($injected->fetchSalesOfWeek($store),2)}}</h6>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <img src="{{asset('dashboard/images/icon/discount.png')}}" alt="Images">
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="single-today-card d-flex align-items-center">
                    <div class="flex-grow-1">
                        <span class="today">Order Of This Week</span>
                        <h6>{{$injected->fetchOrdersOfWeek($store)}}</h6>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <img src="{{asset('dashboard/images/icon/discount.png')}}" alt="Images">
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="single-today-card d-flex align-items-center">
                    <div class="flex-grow-1">
                        <span class="today">Pending Orders</span>
                        <h6>{{$injected->fetchPendingOrders($store)}}</h6>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <img src="{{asset('dashboard/images/icon/discount.png')}}" alt="Images">
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="single-today-card d-flex align-items-center">
                    <div class="flex-grow-1">
                        <span class="today">Completed Orders</span>
                        <h6>{{$injected->fetchCompletedOrders($store)}}</h6>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <img src="{{asset('dashboard/images/icon/discount.png')}}" alt="Images">
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="single-today-card d-flex align-items-center">
                    <div class="flex-grow-1">
                        <span class="today">Processing Orders</span>
                        <h6>{{$injected->fetchProcessingOrders($store)}}</h6>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <img src="{{asset('dashboard/images/icon/discount.png')}}" alt="Images">
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="overview-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7">
                <div class="chart-wrap">
                    <div class="sales-overview d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="overview-content">
                                Sales Overview
                                @if($injected->fetchCurrentMonthSales($store) > $injected->fetchLastMonthSales($store))
                                    <i class="ri-arrow-up-fill" style="font-size: 15px;"></i>

                                @elseif($injected->fetchCurrentMonthSales($store) < $injected->fetchLastMonthSales($store))
                                    <i class="ri-arrow-down-fill text-danger" style="font-size: 15px;"></i>
                                @else
                                    <i class="ri-arrow-up-down-fill" style="font-size: 15px;"></i>
                                @endif
                                <span class="more">
                                    {{number_format($injected->fetchPercentageSaleChange($store),2)}}%
                                </span>
                            </h6>
                        </div>

                        <div class="flex-shrink-0 align-self-center">
                            <ul>
                                <li>
                                    <span>This Month</span>
                                    <h6 class="this-month">{{$store->currency}}{{$injected->formatNumber($injected->fetchCurrentMonthSales($store),2)}}</h6>
                                </li>
                                <li>
                                    <span>Last Month</span>
                                    <h6>{{$store->currency}}{{$injected->formatNumber($injected->fetchLastMonthSales($store),2)}}</h6>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div id="order_anal"></div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="active-user">
                    <div id="order_money_anal"></div>

                    <div class="active-user-content-wrap">
                        <h6 class="active-user-content">
                            Store Customers
                            <i class="ri-arrow-up-line"></i>
                        </h6>

                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-sm-6 col-md-6 col-6">
                                <div class="active-single-item">
                                    <p>
                                        <img src="{{asset('dashboard/images/icon/user-2.png')}}" alt="Images">
                                        Users
                                        <span>{{$injected->formatNumber($injected->totalStoreUsers($store))}}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6 col-md-6 col-6">
                                <div class="active-single-item">
                                    <p>
                                        <img src="{{asset('dashboard/images/icon/discount-2.png')}}" alt="Images">
                                        Average Purchase/Order
                                        <span>{{$store->currency}} {{$injected->formatNumber($injected->fetchAveragePurchaseAmount($store))}}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="analytics-area">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-7">
                <div class="analytics-wrap">
                    <h3>Sales Analytics</h3>

                    <div id="online-offline-anal"></div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="country-chart mb-0">
                    <h3>Country Base Customers</h3>
                    <div id="country-charts"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="latest-transaction-area">
    <div class="container-fluid">
        <div class="table-responsive h-auto" data-simplebar>
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
                <tbody>
                @foreach($injected->latestUncompletedOrders($store) as $order)
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
    </div>
</div>



@push('js')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{route('user.order.analytics')}}',
                method: 'GET',
                success: function(response) {
                    var options = {
                        chart: {
                            height: 395,
                            type: "area",
                            stacked: !0,
                            toolbar: {
                                show: !1,
                                autoSelected: "zoom"
                            }
                        },
                        colors: ["#A52A2A", "#097969"],
                        dataLabels: { enabled: !1 },
                        stroke: {
                            curve: "smooth",
                            width: [1.5, 1.5],
                            dashArray: [0, 4],
                            lineCap: "round"
                        },
                        grid: {
                            padding: { left: 0, right: 0 },
                            strokeDashArray: 3
                        },
                        markers: {
                            size: 0,
                            hover: { size: 0 }
                        },
                        series: [
                            { name: "Pending Order", data: response.pendingOrderData },
                            { name: "Completed Order", data: response.completedOrderData },
                        ],
                        xaxis: {
                            type: "month",
                            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                            axisBorder: { show: !0 },
                            axisTicks: { show: !0 }
                        },
                        fill: {
                            type: "gradient",
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0,
                                opacityTo: 0,
                                stops: [0, 90, 100]
                            }
                        },
                        tooltip: {
                            x: { format: "dd/MM/yy HH:mm" },
                            y: {
                                formatter: function (val) {
                                    return response.currency + val;
                                }
                            }
                        },
                        legend: {
                            position: "bottom",
                            horizontalAlign: "right",
                            show: false
                        },
                    };
                    var chart = new ApexCharts(document.querySelector("#order_anal"), options);
                    chart.render();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching order data:', error);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{route('user.country.analytics')}}',
                method: 'GET',
                success: function(response) {
                    var options = {
                        series: response.countryCounts,
                        chart: {
                            type: "donut",
                            height: 262
                        },
                        labels: response.countryLabels,
                        colors: [
                            "#21BDFD",
                            "#7F26C6",
                            "#FB5264",
                            "#FAB134"
                        ],
                        legend: {
                            show: !1
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: "70%"
                                }
                            }
                        }
                    };
                    var chart = new ApexCharts(document.querySelector("#country-charts"), options);
                    chart.render();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching analytics data:', error);
                }
            });
        });
    </script>
    <!-- Apexcharts Min JS -->
    <script src="{{asset('dashboard/js/apexcharts/apexcharts.min.js')}}"></script>
    <!-- Charts Custom Min JS -->
    <script src="{{asset('dashboard/js/charts-custom.js')}}"></script>
    <script>
        $(document).ready(function (){
            $.ajax({
                url: '{{route('user.customer.analytics')}}',
                method: 'GET',
                success: function(response) {
                    var customerData = response;

                    var seriesData = [];
                    var categories = [];

                    customerData.forEach(function(data) {
                        var monthYear = data.month + '-' + data.year;
                        categories.push(monthYear);
                        seriesData.push(data.count);
                    });

                    var options = {
                        chart: {
                            height: 385,
                            type: "area",
                            stacked: !0,
                            toolbar: {
                                show: !1
                            },
                            zoom: {
                                enabled: !0
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: !1,
                                columnWidth: "15%",
                                endingShape: "rounded"
                            }
                        },
                        dataLabels: {
                            enabled: !1
                        },
                        series: [
                            { name: "Number of Customers", data: seriesData },
                        ],
                        colors: ["#ff9f43"],
                        legend: { position: "top" },
                        fill: { opacity: 1 },
                        xaxis: {
                            categories: categories,
                            title: {
                                text: "Month-Year"
                            }
                        }
                    };

                    var chart = new ApexCharts(
                        document.querySelector("#order_money_anal"),
                        options
                    );

                    chart.render();
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching customer analytics:", error);
                }
            });
        })
    </script>

    <script>
        function fetchSalesAnalytics() {
            $.ajax({
                url:'{{route('user.customer.online.offline')}}' ,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let onlineSalesData = new Array(12).fill(0);
                    let offlineSalesData = new Array(12).fill(0);

                    data.onlineSales.forEach(item => {
                        onlineSalesData[item.month - 1] = parseFloat(item.total);
                    });

                    data.offlineSales.forEach(item => {
                        offlineSalesData[item.month - 1] = parseFloat(item.total);
                    });

                    plotSalesAnalytics(onlineSalesData, offlineSalesData);
                },
                error: function(error) {
                    console.log('Error fetching sales analytics:', error);
                }
            });
        }

        function plotSalesAnalytics(onlineSales, offlineSales) {
            var options = {
                chart: {
                    height: 385,
                    type: "bar",
                    stacked: true,
                    toolbar: { show: false },
                    zoom: { enabled: true }
                },
                plotOptions: {
                    bar: { horizontal: false, columnWidth: "15%", endingShape: "rounded" }
                },
                dataLabels: { enabled: false },
                series: [
                    { name: "Online checkout", data: onlineSales },
                    { name: "Offline checkout", data: offlineSales },
                ],
                xaxis: {
                    categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
                },
                colors: ["#EE7071", "#8A80F3"],
                legend: { position: "top"},
                fill: { opacity: 1 },
            };
            var chart = new ApexCharts(document.querySelector("#online-offline-anal"), options);
            chart.render();
        }

        // Call the function when the page loads
        $(document).ready(function() {
            fetchSalesAnalytics();
        });
    </script>
@endpush
