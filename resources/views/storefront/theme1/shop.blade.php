@extends('storefront.theme1.layout.base')
@section('content')
    @inject('options','App\Custom\Storefront')
    <!--start breadcrumb-->
    <div class="py-4 border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('merchant.store',['subdomain'=>$subdomain])}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shop</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <section class="section-padding bg-section-2">
        <div class="container">
            <div class="d-flex align-items-center">
                <div class="">
                    <h3 class="mb-0 fw-bold">Search Products</h3>
                </div>
            </div>
            <form method="get" action="{{route('merchant.store.shop.search',['subdomain'=>$subdomain])}}">
                <div class="search-box position-relative mt-4">
                    <div class="position-absolute position-absolute top-50 start-0 translate-middle ms-4 fs-5"><i class="bi bi-search"></i></div>
                    <input class="form-control form-control-lg ps-5 rounded-0" type="text" placeholder="Type here to search" name="search">
                </div>
            </form>
        </div>
    </section>

    <section class="py-4">
        <div class="container">

            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="shop-right-sidebar">

                        <div class="product-grid mt-4">
                            <div id="product-list" class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center">
                                @include('storefront.theme1.previews.product_list',['products' => $products])
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button id="load-more" class="btn btn-light" data-url="{{ route('merchant.store.shop', ['subdomain' => $subdomain]) }}">Load More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


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
    @endpush
@endsection
