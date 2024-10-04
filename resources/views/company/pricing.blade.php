@extends('company.layout.base')
@section('content')

    <div class="inner_banner-section">
        <img class="inner_banner-background-image" src="{{asset('home/image/common/inner-bg.png')}}" alt="image alt">
        <div class="container">
            <div class="inner_banner-content-block">
                <h3 class="inner_banner-title">{{$pageName}}</h3>
                <ul class="banner__page-navigator">
                    <li>
                        <a href="{{url('/')}}">Home</a>
                    </li>
                    <li class="active">
                        <a href="{{url()->current()}}">
                            {{$pageName}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="pricing_main_pricing-section section-padding-120">
        <div class="container">
            <div class="row text-center justify-content-center">
                <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">
                    <div class="section-heading">
                        <h2 class="section-heading__title heading-lg ">Our pricing plans are designed for your favor</h2>
                        <p>
                            Running a business is already expensive and we understand this. This is why we have made our
                            pricing to be the lowest in the market while offering you the best solution better than others.
                        </p>
                        <div class="home-8_pricing-control-block">
                            <div class="btn-group">
                                @foreach($fiats as $fiatss)
                                    <input type="radio" class="btn-check currency" name="options" id="option{{$fiatss->code}}"
                                        {{($fiatss->code==$fiat->code)?'checked':''}}
                                        data-value="{{route('home.pricing',['currency'=>$fiatss->code])}}#plan"/>
                                    <label class="btn btn-primary" for="option{{$fiatss->code}}">{{$fiatss->code}}</label>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row justify-content-center" data-plan-id="pricing-1" data-plan-active="monthly">
                <div class="col-xxl-10 col-lg-12 col-md-8 col-sm-10">
                    <div class=" pricing-card-6">
                        <div class="pricing-card-6__head" id="plan">
                            <span class="pricing-card-6__plan">For Merchants</span>
                            <h2 class="pricing-card-6__price-plan">
                                <span class="pricing-card-6__price dynamic-value" data-yearly="Free" data-monthly="Free">Free</span>
                                <span class="pricing-card-6__time dynamic-value" data-yearly="/Per Year" data-monthly="/Per Month">/Per Month</span>
                            </h2>
                            <p>
                                For a limited period, we are offering our listing and storefront solution for free.
                            </p>
                        </div>
                        <div class="pricing-card-6__body">
                            <h3 class="pricing-card-6__badge">That includes:</h3>
                            <ul class="pricing-card-6__list">
                                <li class="pricing-card-6-list-item"><img src="{{asset('home/image/icons/icon-check-purple.svg')}}" alt="image alt" class="icon">
                                    <span>Live chat and email</span>
                                </li>
                                <li class="pricing-card-6-list-item"><img src="{{asset('home/image/icons/icon-check-purple.svg')}}" alt="image alt" class="icon">
                                    <span>Unlimited products</span>
                                </li>
                                <li class="pricing-card-6-list-item"><img src="{{asset('home/image/icons/icon-check-purple.svg')}}" alt="image alt" class="icon">
                                    <span>{{$web->fileUploadAllowed}} Product Photos</span>
                                </li>
                                <li class="pricing-card-6-list-item"><img src="{{asset('home/image/icons/icon-check-purple.svg')}}" alt="image alt" class="icon">
                                    <span>Full store analytics</span>
                                </li>
                                <li class="pricing-card-6-list-item"><img src="{{asset('home/image/icons/icon-check-purple.svg')}}" alt="image alt" class="icon">
                                    <span>24/7 support centre</span>
                                </li>
                                <li class="pricing-card-6-list-item"><img src="{{asset('home/image/icons/icon-check-purple.svg')}}" alt="image alt" class="icon">
                                    <span>Custom Store-design on-demand</span>
                                </li>
                                <li class="pricing-card-6-list-item"><img src="{{asset('home/image/icons/icon-check-purple.svg')}}" alt="image alt" class="icon">
                                    <span>
                                        {{$fiat->charge}}% + {{$fiat->sign}}{{$fiat->transactionCharge}} per online checkout
                                        @if($fiat->maxCharge!=0 && !empty($fiat->maxCharge))
                                            Capped at {{$fiat->sign}}{{$fiat->maxCharge}}
                                        @endif
                                        <sup><i class="fa fa-info-circle"
                                            data-bs-toggle="tooltip" title="Exclusive of payment processor's fees."></i></sup>
                                    </span>
                                </li>
                            </ul>
                            <div class="pricing-card-6__button">
                                <a href="{{route('register')}}" class="btn-masco btn-primary-l08 btn-fill--slide w-100">
                                    <span>Get Started</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
