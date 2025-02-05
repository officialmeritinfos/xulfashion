@extends('mobile.ads.layout.base')
@section('content')
    <!-- banner section start -->
    <section class="banner-wapper">
        <div class="custom-container">
            <div class="banner-bg">
                <img class="img-fluid img-bg w-100" src="{{asset('mobile/images/banner/banner-1.jpg')}}" alt="banner-1" />
                <div class="banner-content">
                    <h2 class="fw-semibold">Explore the Best Stores</h2>
                    <h5 class="text-white">
                        Discover the top-rated stores in your city <br/> and shop the latest trends with ease.
                    </h5>
                </div>
                <a href="{{route('mobile.marketplace.stores')}}" class="more-btn">
                    <h4>View More</h4>
                    <i class="iconsax right-arrow" data-icon="arrow-right"></i>
                </a>
            </div>
        </div>
    </section>
    <!-- banner section start -->

    <!-- categories section start -->
    <section>
        <div class="custom-container">
            <div class="swiper categories">
                <div class="swiper-wrapper ratio_square">
                    @foreach($serviceTypes as $key=> $serviceType)
                        <div class="swiper-slide">
                            <a href="{{route('mobile.marketplace.service',['id'=>$serviceType->id])}}" class="categories-item {{($key==0)?'active':''}}">
                                <h4>{{$serviceType->name}}</h4>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- categories section end -->

    <!-- New Arrivals section start -->
    <section class="section-t-space">
        <div class="custom-container">
            <div class="title">
                <h2>Newest Listing</h2>
            </div>

            <div class="row g-3">
                @foreach($recentAds as  $index => $recentAd)
                <div class="col-6">
                    <div class="product-box">
                        <div class="product-box-img">
                            <a href="{{route('mobile.marketplace.detail',['slug'=>textToSlug($recentAd->title),'id'=>$recentAd->reference])}}">
                                <img class="img" src="{{$recentAd->featuredImage}}" alt="p1" />
                            </a>

                            <div class="cart-box">
                                <a href="{{route('mobile.marketplace.detail',['slug'=>textToSlug($recentAd->title),'id'=>$recentAd->reference])}}" class="cart-bag">
                                    <i class="iconsax bag" data-icon="basket-2"></i>
                                </a>
                            </div>
                        </div>

                        <div class="product-box-detail">
                            <h4>{{$recentAd->title}}</h4>
                            <h5> {{ $recentAd->service->name }}</h5>
                            <div class="d-flex justify-content-between gap-3">
                                <h5>By: {{$recentAd->companyName}}</h5>
                                <h3 class="text-end">
                                    {{getStateFromIso2($recentAd->state,$country->iso2)->name}}
                                </h3>
                            </div>

                            <div class="bottom-panel">
                                <div class="price">
                                    <h4>
                                        @empty($recentAd->amount)
                                            Contact for Price
                                        @else
                                            {{currencySign($recentAd->currency)}} {{number_format($recentAd->amount,2)}}
                                        @endempty
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- New Arrivals section end -->

    <section class="section-t-space">
        <div class="custom-container">
            <div class="title">
                <h2>Trending Ads</h2>
            </div>

            <div class="row g-3">
                @foreach($ads as $ad)
                    <div class="col-12">
                        <div class="horizontal-product-box">
                            <a href="{{route('mobile.marketplace.detail',['slug'=>textToSlug($ad->title),'id'=>$ad->reference])}}" class="horizontal-product-img">
                                <img class="img-fluid img" src="{{$ad->featuredImage}}" alt="p3" />
                            </a>
                            <div class="horizontal-product-details">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4>{{$ad->title}}</h4>
                                </div>
                                <h5>{{ $ad->service->name }}</h5>
                                <div class="d-flex justify-content-between gap-3">
                                    <h5>By: {{$ad->companyName}}</h5>
                                    <h3 class="text-end">
                                        {{getStateFromIso2($ad->state,$country->iso2)->name}}
                                    </h3>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <div class="d-flex align-items-center gap-2">
                                        <h3 class="fw-semibold">
                                            @empty($ad->amount)
                                                Contact for Price
                                            @else
                                                {{currencySign($ad->currency)}} {{number_format($ad->amount,2)}}
                                            @endempty
                                        </h3>
                                    </div>
                                    <a href="{{route('mobile.marketplace.detail',['slug'=>textToSlug($ad->title),'id'=>$ad->reference])}}" class="cart-bag">
                                        <i class="iconsax bag" data-icon="basket-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    @if(!empty($bestSelling))
        <!-- banner section start -->
        <section class="banner-wapper">
            <div class="custom-container">
                <div class="banner-bg">
                    <img class="img-fluid img-bg" src="{{$bestSelling->featuredImage}}" alt="banner-2" />
                    <div class="banner-content">
                        <h2 class="fw-semibold">Best Selling</h2>
                        <h4>{{$bestSelling->title}}</h4>
                    </div>
                    <a href="{{route('mobile.marketplace.detail',['slug'=>textToSlug($bestSelling->title),'id'=>$bestSelling->reference])}}" class="more-btn">
                        <h4>View More</h4>
                        <i class="iconsax right-arrow" data-icon="arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>
        <!-- banner section end -->
    @endif

    @foreach($serviceTypes as $serviceType)
        @if(trendingInCategory($serviceType->id)->count()>0)
            <!-- other furniture section start -->
            <section class="section-t-space">
                <div class="custom-container">
                    <div class="title">
                        <h2>{{$serviceType->name}}</h2>
                        <a href="{{route('mobile.marketplace.service',['id'=>$serviceType->id])}}">View All</a>
                    </div>

                    <div class="row g-4">
                        @foreach(trendingInCategory($serviceType->id) as $trendingInCategory)
                            <div class="col-6">
                                <div class="product-box">
                                    <div class="product-box-img">
                                        <a href="{{route('mobile.marketplace.detail',['slug'=>textToSlug($trendingInCategory->title),'id'=>$trendingInCategory->reference])}}"> <img class="img" src="{{$trendingInCategory->featuredImage}}" alt="p10" /></a>

                                        <div class="cart-box">
                                            <a href="{{route('mobile.marketplace.detail',['slug'=>textToSlug($trendingInCategory->title),'id'=>$trendingInCategory->reference])}}" class="cart-bag">
                                                <i class="iconsax bag" data-icon="basket-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-box-detail">
                                        <h4>{{$trendingInCategory->title}}</h4>
                                        <h5>{{serviceTypeById($trendingInCategory->serviceType)->name}}</h5>
                                        <div class="d-flex justify-content-between gap-3">
                                            <h5>By: {{$trendingInCategory->companyName}}</h5>
                                            <h3 class="text-end">
                                                {{getStateFromIso2($trendingInCategory->state,$trendingInCategory->country)->name}}
                                            </h3>
                                        </div>
                                        <div class="bottom-panel">
                                            <div class="price">
                                                <h4>
                                                    @empty($trendingInCategory->amount)
                                                        Contact for Price
                                                    @else
                                                        {{currencySign($trendingInCategory->currency)}} {{number_format($trendingInCategory->amount,2)}}
                                                    @endempty
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </section>
            <!-- other furniture section end -->
        @endif
    @endforeach



    @push('js')
        <script>
            $(document).ready(function () {
                let industrySelect = $('select[name="industry"]'); // Select industry dropdown
                let categorySelect = $('select[name="category"]'); // Select category dropdown
                let selectedIndustry = industrySelect.val(); // Get the selected industry
                let submitBtn = $('.search-btn');
                let selectedCategory = categorySelect.data('selected'); // Get the preselected category

                // Function to fetch categories dynamically
                function fetchCategories(industry, selectedCategory = null) {
                    if (industry) {
                        submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
                        $.ajax({
                            url: "{{ route('mobile.industry.categories') }}",
                            type: 'GET',
                            data: { mainCategory: industry },
                            success: function (response) {
                                categorySelect.empty().append('<option value="">All</option>'); // Clear previous options

                                // Append categories dynamically
                                $.each(response, function (index, category) {
                                    let isSelected = selectedCategory && selectedCategory == category.id ? 'selected' : '';
                                    categorySelect.append('<option value="' + category.id + '" ' + isSelected + '>' + category.name + '</option>');
                                });
                            },
                            error: function () {
                                console.log('Failed to fetch categories');
                            },
                            complete: function () {
                                // Restore submit button after request completes
                                submitBtn.prop('disabled', false).html('<i class="fa fa-search"></i>');9
                            }
                        });
                    } else {
                        categorySelect.empty().append('<option value="">All</option>'); // Reset if no industry is selected
                    }
                }

                // Fetch categories when industry changes
                industrySelect.on('change', function () {
                    let industryValue = $(this).val();
                    fetchCategories(industryValue);
                });

                // Fetch categories on page load if industry and category are set
                if (selectedIndustry) {
                    fetchCategories(selectedIndustry, selectedCategory);
                }
            });

        </script>
    @endpush
@endsection
