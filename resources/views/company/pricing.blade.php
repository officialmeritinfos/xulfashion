@extends('company.layout.base')
@section('content')

    <!--
		=====================================================
			Pricing Section Six
		=====================================================
		-->
    <div class="pricing-section-six mt-250 xl-mt-200 lg-mt-150">
        <div class="container lg">
            <div class="row">
                <div class="col-xl-4 col-lg-6 m-auto m-xl-0 text-center text-xl-start">
                    <div class="title-eleven">
                        <h2>Our pricing plans are designed for your favor</h2>
                    </div>
                    <p>
                        Running a business is already expensive and we understand this. This is why we have made our
                        pricing to be the lowest in the market while offering you the best solution better than others.
                    </p>

                </div>
                <div class="col-xl-8">
                    <div class="tab-content ps-xxl-5">
                        <div class="tab-pane show active fade" id="monthly" role="tabpanel" aria-labelledby="buy-tab" tabindex="0">
                            <div class="row">
                                <div class="col-lg-6 d-flex">
                                    <div class="pr-column w-100">
                                        <div class="pr-header text-center mb-25">
                                            <div class="plane-name">Merchant</div>
                                            <div class="info1 fs-20">For a limited period, we are offering our listing and storefront solution for free.</div>
                                            <div class="price">{{$fiat->sign}}0<sub>/mo*</sub></div>
                                            <div class="info2 fs-20">
                                                {{ calculateChargeRate($fiat->charge) }}% + {{$fiat->sign}}{{calculateChargeRate($fiat->transactionCharge)}} per online checkout
                                                @if($fiat->maxCharge!=0 && !empty($fiat->maxCharge))
                                                    Capped at {{$fiat->sign}}{{$fiat->maxCharge}}
                                                @endif <sup><i class="fa fa-info-circle"
                                                               data-bs-toggle="tooltip" title="Inclusive of payment processor's fees."></i></sup>
                                            </div>
                                            @if($web->hasPromo==1)
                                                <div class="save-line fs-20 fw-500">Save {{ $web->promoRate }}% on transaction fees</div>
                                            @endif

                                        </div>
                                        <!-- /.pr-header -->
                                        <a href="{{ route('mobile.register') }}" class="btn-eleven w-100 d-flex justify-content-between align-items-center">
                                            Start Now<span class="icon tran3s d-flex align-items-center justify-content-center"><i class="bi bi-chevron-right"></i></span></a>
                                        <h6>Features</h6>
                                        <ul class="style-none package-feature">
                                            <li>Live chat and email support</li>
                                            <li>Unlimited products</li>
                                            <li>{{$web->fileUploadAllowed}} Product Photos</li>
                                            <li>Full store analytics</li>
                                            <li>24/7 support</li>
                                            <li>Custom Store-design </li>
                                            <li>Free SSL Certificate</li>
                                            <li>Free Website</li>
                                            <li>Receive Payments in:
                                                @foreach($fiats as $fiatss)
                                                    <span class="badge bg-primary">{{$fiatss->code}}</span>
                                                @endforeach
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- /.pr-column -->
                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- /.tab-content -->
                </div>

            </div>
        </div>
    </div>
    <!-- /.pricing-section-six -->    <!--
		=====================================================
			Pricing Section Six
		=====================================================
		-->
    <div class="pricing-section-six mt-250 xl-mt-200 lg-mt-150">
        <div class="container lg">
            <div class="row">
                <div class="col-xl-4 col-lg-6 m-auto m-xl-0 text-center text-xl-start">
                    <div class="title-eleven">
                        <h2>Event Management Fee</h2>
                    </div>
                    <p>
                        {{ $siteName }} is the go-to place for all Fashion & Beauty Events. Our fee structure is the fairest
                        in the market with a wider audience reach. <br/> <strong>Note:</strong> Hosting an event on {{$siteName}}
                        is free for Free events. We only charge you on paid tickets.<br/>
                        By Default, your buyers bear the charge, but you can configure each ticket to set who would bear the charge.
                    </p>

                </div>
                <div class="col-xl-8">
                    <div class="tab-content ps-xxl-5">
                        <div class="tab-pane show active fade" id="monthly" role="tabpanel" aria-labelledby="buy-tab" tabindex="0">
                            <div class="row">
                                <div class="col-lg-6 d-flex">
                                    <div class="pr-column w-100">
                                        <div class="pr-header text-center mb-25">
                                            <div class="plane-name">Event Management</div>
                                            <div class="info1 fs-20">It is completely free to host a free event on {{ $siteName }}</div>
                                            @if($web->hasPromo==1)
                                                <div class="save-line fs-20 fw-500">Save {{ $web->promoRate }}% on transaction fees</div>
                                            @endif
                                            <div class="price"> {{ calculateChargeRate($fiat->charge) }}<sub>%</sub></div>
                                            <div class="info2 fs-20">
                                                + {{$fiat->sign}}{{ calculateChargeRate($fiat->transactionCharge) }} per online checkout
                                            </div>

                                        </div>
                                        <!-- /.pr-header -->
                                        <a href="{{ route('mobile.register') }}" class="btn-eleven w-100 d-flex justify-content-between align-items-center">
                                            Start Now<span class="icon tran3s d-flex align-items-center justify-content-center"><i class="bi bi-chevron-right"></i></span></a>
                                        <h6>Features</h6>
                                        <ul class="style-none package-feature">
                                            <li>No fee on free tickets</li>
                                            <li>Unlimited free events</li>
                                            <li>Unlimited paid events</li>
                                            <li>Virtual Events</li>
                                            <li>Recurring events</li>
                                            <li>24/7 support</li>
                                            <li>Pass online ticket fees to attendees</li>
                                            <li>Supported Currencies:
                                                @foreach($fiats as $fiatss)
                                                    <span class="badge bg-primary">{{$fiatss->code}}</span>
                                                @endforeach
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- /.pr-column -->
                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- /.tab-content -->
                </div>
                <div class="col-md-12 mt-80">
                    <h3 class="text-center">Looking for our complete fees structure for other supported currencies?</h3>
                    <div class="row">
                        <div class="col-lg-12 d-flex mb-40 md-mb-20">
                            <div class="card-style-two tran3s w-100">
                                <div class="wrapper tran3s d-flex flex-column h-100 position-relative">
                                    <div class="d-flex justify-content-between align-items-center mb-160 xl-mb-120 lg-mb-80 position-relative z-1">
                                        <h3 class="tran3s">Our Full Fee Structure</h3>
                                        <img src="{{asset('home/mobile/images/shape/shape_08.svg')}}" alt="" class="shapes pointer">
                                        <div class="icon tran3s rounded-circle d-flex align-items-center justify-content-center"><img src="{{asset('home/mobile/images/icon/icon_07.svg')}}" alt=""></div>
                                    </div>
                                    <p class="font-manrope tran3s mt-auto">
                                        Find the full details about our pricing for receiving payments, withdrawals etc.
                                    </p>
                                    <a href="https://xulfashion-know.tawk.help/category/orders-and-payments" target="_blank" class="stretched-link"></a>
                                </div>
                            </div>
                            <!-- /.card-style-two -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.pricing-section-six -->


    @push('js')
        <script>
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        </script>
        <script>
            $(function (){
                $('.currency').on('change',function (){
                    var url = $(this).data('value');
                    window.location.href=url;
                });
            });
        </script>
    @endpush

@endsection
