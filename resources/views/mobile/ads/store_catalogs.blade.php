@extends('mobile.ads.layout.innerBase')
@section('content')
    <section>
        <div class="custom-container">
            <form class="theme-form search-head" target="_blank">
                <div class="form-group">
                    <div class="form-input w-100">
                        <input type="text" class="form-control search" id="inputusername" placeholder="Search here..." />
                        <i class="iconsax search-icon" data-icon="search-normal-2"></i>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Categories section start -->
    <section class="mt-2">
        <div class="custom-container">
            <ul class="categories-list">

                @foreach($catalogs as $key => $catalog)
                    <li class="category-item {{($key == 0) ? 'mt-0' : ''}}" data-name="{{$catalog->categoryName}}">
                        <a href="{{route('mobile.marketplace.catalog.detail',['store'=>$store->reference,'catalog'=>$catalog->id])}}" class="d-flex align-items-center">
                            <div class="ps-3">
                                <h2>{{$catalog->categoryName}}</h2>
                                <h4 class="mt-1">{{numberOfProductsInCategory($catalog->id)}} Products</h4>
                                <div class="arrow">
                                    <i class="iconsax right-arrow" data-icon="arrow-right"></i>
                                </div>
                            </div>
                            <div class="categories-img">
                                <img class="img-fluid img" src="{{$catalog->photo??asset('customcategory.jpg')}}" alt="p3" />
                            </div>
                        </a>
                    </li>

                @endforeach
            </ul>
            <!-- No matching categories message -->
            <div class="empty-tab" style="display: none;">
                <img class="img-fluid empty-img w-100" src="{{asset('mobile/images/gif/search.gif')}}" alt="empty-search" />
                <h2>No Matching Catalog</h2>
                <h5 class="mt-3">We could not find your requested catalog, please checkout another category</h5>
            </div>
        </div>
    </section>

    @push('js')
        <!-- jQuery Script to filter categories -->
        <script>
            $(document).ready(function() {
                $('#inputusername').on('keyup', function() {
                    var searchText = $(this).val().toLowerCase();
                    var matchFound = false;

                    $('.category-item').each(function() {
                        var categoryName = $(this).data('name').toLowerCase();
                        if (categoryName.includes(searchText)) {
                            $(this).show();
                            matchFound = true;
                        } else {
                            $(this).hide();
                        }
                    });

                    // If no match found, display the 'No Matching Category' message
                    if (!matchFound) {
                        $('.empty-tab').show();
                        $('.categories-list').hide();
                    } else {
                        $('.empty-tab').hide();
                        $('.categories-list').show();
                    }
                });
            });
        </script>
    @endpush
@endsection
