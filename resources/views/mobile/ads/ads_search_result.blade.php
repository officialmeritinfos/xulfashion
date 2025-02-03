@extends('mobile.ads.layout.innerBase')
@section('content')

    <section class="section-b-space">
        <div class="custom-container">
            @if($ads->count()>0)
                <div class="row g-3" id="product-list">
                    @include('mobile.ads.layout.ads_listing')
                </div>
                @if ($ads->hasMorePages())
                <div class="text-center mt-4">
                    <button id="load-more" class="btn btn-light" data-url="{{ url()->full() }}">Load More</button>
                </div>
                @endif
            @else
                <div class="empty-tab">
                    <img class="img-fluid empty-img w-100" src="{{asset('mobile/images/gif/search.gif')}}" alt="empty-search" />

                    <h2>No Result to Show</h2>
                    <h5 class="mt-3">No ads found matching the filter. Checkout the listing below</h5>
                </div>
            @endif
        </div>
    </section>

    @if($others->count()>0)
        <!-- shop section start -->
        <section class="section-b-space">
            <div class="custom-container">
                <div class="title">
                    <h2>Similar Ads</h2>
                </div>
                <div class="row g-3">
                    @foreach($others as $other)
                        <div class="col-6">
                            <div class="product-box">
                                <div class="product-box-img">
                                    <a href=""{{route('mobile.marketplace.detail',['slug'=>textToSlug($other->title),'id'=>$other->reference])}}"> <img class="img" src="{{$other->featuredImage}}" alt="p1" /></a>

                                    <div class="cart-box">
                                        <a href="{{route('mobile.marketplace.detail',['slug'=>textToSlug($other->title),'id'=>$other->reference])}}" class="cart-bag">
                                            <i class="iconsax bag" data-icon="basket-2"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-box-detail">
                                    <h4>{{$other->title}}</h4>
                                    <h5>{{$other->service->name}}</h5>
                                    <div class="d-flex justify-content-between gap-3">
                                        <h5>By: {{$other->companyName}}</h5>
                                        <h3 class="text-end">
                                           {{getStateFromIso2($other->state,$country->iso2)->name}}
                                        </h3>
                                    </div>
                                    <div class="bottom-panel">
                                        <div class="price">
                                            <h4>
                                                @empty($other->amount)
                                                    Contact for Price
                                                @else
                                                    {{currencySign($other->currency)}} {{number_format($other->amount,2)}}
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
    @endif


    @push('js')
        <script>
            $(document).ready(function() {
                let page = 1;
                let loadMoreBtn = $('#load-more');
                let loadMoreUrl = loadMoreBtn.data('url');
                let originalText = loadMoreBtn.text();

                loadMoreBtn.click(function() {
                    page++;
                    //show loading icon
                    loadMoreBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                    $.ajax({
                        url: loadMoreUrl,
                        type: 'GET',
                        data: { page: page },
                        success: function(response) {
                            if(response.products) {
                                $('#product-list').append(response.products);
                                if(!response.hasMorePages) {
                                    loadMoreBtn.hide();
                                } else {
                                    loadMoreBtn.text(originalText);
                                }
                            }else {
                                loadMoreBtn.text(originalText);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading more products:', error);
                            loadMoreBtn.text(originalText);
                        }
                    });
                });
            });
        </script>

        <script>
            $(document).ready(function () {
                let industrySelect = $('select[name="industry"]'); // Select industry dropdown
                let categorySelect = $('select[name="category"]'); // Select category dropdown
                let selectedIndustry = industrySelect.val(); // Get the selected industry
                let selectedCategory = categorySelect.data('selected'); // Get the preselected category

                // Function to fetch categories dynamically
                function fetchCategories(industry, selectedCategory = null) {
                    if (industry) {
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
