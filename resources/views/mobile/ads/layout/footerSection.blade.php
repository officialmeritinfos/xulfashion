
<!-- filter offcanvas start -->
<div class="modal search-filter" id="search-filter" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-title">
                <a href="#" data-bs-dismiss="modal">
                    <i class="iconsax back-btn" data-icon="arrow-left"></i>
                </a>
                <h3 class="fw-semibold">Filter</h3>
            </div>

            <div class="tab-body d-flex align-items-start">

                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                    <button class="nav-link active" id="v-pills-sort-tab" data-bs-toggle="pill" data-bs-target="#v-pills-sort" type="button" role="tab"
                            aria-controls="v-pills-sort" aria-selected="true">Sort By</button>


                    <button class="nav-link" id="v-pills-price-tab" data-bs-toggle="pill" data-bs-target="#v-pills-price" type="button" role="tab"
                            aria-controls="v-pills-price" aria-selected="false">Price</button>
                </div>

                <div class="tab-content" id="v-pills-tabContent">

                    <div class="tab-pane tab-info fade show active" id="v-pills-sort" role="tabpanel" aria-labelledby="v-pills-sort-tab" tabindex="0">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sortBy" id="radio2" value="price-high"/>
                            <label class="form-check-label" for="radio2">Highest Priced First</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sortBy" id="radio3" value="price-low" />
                            <label class="form-check-label" for="radio3">Lowest Priced First</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sortBy" id="radio5" value="desc" checked/>
                            <label class="form-check-label" for="radio5">Newest</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sortBy" id="radio5" value="asc"/>
                            <label class="form-check-label" for="radio5">Oldest</label>
                        </div>
                    </div>

                    <div class="tab-pane price-info fade" id="v-pills-price" role="tabpanel" aria-labelledby="v-pills-price-tab" tabindex="0">
                        <div class="range-slider">
                                <span>From <input type="number" min="0"  step="1"
                                                  name="minPrice"/> To <input type="number"  min="0"  step="1" name="maxPrice"/> </span>
                        </div>
                    </div>
                </div>


                <div class="footer-modal d-flex gap-3">
                    <button type="reset" class="btn gray-btn btn-inline mt-0 w-50 resetFilter">Clear Filter</button>
                    <button type="submit" class="theme-btn btn btn-inline mt-0 w-50 applyFilter" data-bs-dismiss="modal">apply</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- filter offcanvas end -->

<!-- panel-space start -->
<section class="panel-space"></section>
<!-- panel-space end -->

<!-- bottom navbar start -->
<div class="navbar-menu">
    <ul>
        <li class="{{(url()->current()==route('mobile.marketplace.index'))?'active':''}}">
            <a href="{{route('mobile.marketplace.index')}}">
                <div class="icon">
                    <img class="unactive" src="{{asset('mobile/images/svg/home.svg')}}" alt="home" />
                    <img class="active" src="{{asset('mobile/images/svg/home-fill.svg')}}" alt="home" />
                </div>
                <p>Home</p>
            </a>
        </li>
        <li class="{{(url()->current()==route('mobile.marketplace.categories'))?'active':''}}">
            <a href="{{route('mobile.marketplace.categories')}}">
                <div class="icon">
                    <img class="unactive" src="{{asset('mobile/images/svg/categories.svg')}}" alt="categories" />
                    <img class="active" src="{{asset('mobile/images/svg/categories-fill.svg')}}" alt="categories" />
                </div>
                <p>Categories</p>
            </a>
        </li>
        <li class="{{(url()->current()==route('mobile.marketplace.stores'))?'active':''}}">
            <a href="{{route('mobile.marketplace.stores')}}">
                <div class="icon">
                    <img class="unactive" src="{{asset('mobile/images/svg/bag.svg')}}" alt="bag" />
                    <img class="active" src="{{asset('mobile/images/svg/bag-fill.svg')}}" alt="bag" />
                </div>
                <p>Stores</p>
            </a>
        </li>

        @guest()
            <li>
                <a href="{{route('mobile.login')}}">
                    <div class="icon">
                        <img class="unactive" src="{{asset('mobile/images/svg/profile.svg')}}" alt="profile" />
                        <img class="active" src="{{asset('mobile/images/svg/profile-fill.svg')}}" alt="profile" />
                    </div>
                    <p>Register/Sign-in</p>
                </a>
            </li>
        @else

            <li class="{{(url()->current()==route('user.settings.index'))?'active':''}}">
                <a href="{{route('mobile.user.profile.landing-page')}}">
                    <div class="icon">
                        <img class="unactive" src="{{asset('mobile/images/svg/profile.svg')}}" alt="profile" />
                        <img class="active" src="{{asset('mobile/images/svg/profile-fill.svg')}}" alt="profile" />
                    </div>
                    <p>Account</p>
                </a>
            </li>
        @endguest
    </ul>
</div>
<!-- bottom navbar end -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(window).on('load', function() {
        $('.loader-wrapper').fadeOut('slow');
    });

    $(window).on('pageshow', function(event) {
        if (event.originalEvent.persisted) {
            // Page is loaded from cache, hide the preloader
            $('.loader-wrapper').fadeOut('slow');
        }
    });

    $('a').on('click', function(e) {
        // Check if the link has the class "back"
        if (!$(this).hasClass('back')) {
            // If it doesn't have the class "back", show the preloader
            $('.loader-wrapper').fadeIn('fast');
        }
    });
    $(window).on('beforeunload', function() {
        $('.loader-wrapper').show();
    });
</script>

<script src="{{asset('sw-register.js')}}"></script>
