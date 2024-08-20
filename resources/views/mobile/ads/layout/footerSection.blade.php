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
                    <button class="nav-link active" id="v-pills-sort-tab" data-bs-toggle="pill" data-bs-target="#v-pills-sort" type="button" role="tab" aria-controls="v-pills-sort" aria-selected="true">Sort By</button>

                    <button class="nav-link" id="v-pills-color-tab" data-bs-toggle="pill" data-bs-target="#v-pills-color" type="button" role="tab" aria-controls="v-pills-color" aria-selected="false">Color</button>

                    <button class="nav-link" id="v-pills-price-tab" data-bs-toggle="pill" data-bs-target="#v-pills-price" type="button" role="tab" aria-controls="v-pills-price" aria-selected="false">Price</button>

                    <button class="nav-link" id="v-pills-material-tab" data-bs-toggle="pill" data-bs-target="#v-pills-material" type="button" role="tab" aria-controls="v-pills-material" aria-selected="false">Material</button>
                </div>

                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane tab-info fade show active" id="v-pills-sort" role="tabpanel" aria-labelledby="v-pills-sort-tab" tabindex="0">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="radio1" />
                            <label class="form-check-label" for="radio1">Relevance</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio" id="radio2" />
                            <label class="form-check-label" for="radio2">Highest Priced First</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio" id="radio3" checked />
                            <label class="form-check-label" for="radio3">Lowest Priced First</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio" id="radio4" />
                            <label class="form-check-label" for="radio4">Fastest Shipping</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio" id="radio5" />
                            <label class="form-check-label" for="radio5">Newest</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio" id="radio6" />
                            <label class="form-check-label" for="radio6">Highest Rating First</label>
                        </div>
                    </div>

                    <div class="tab-pane tab-info color-info fade" id="v-pills-color" role="tabpanel" aria-labelledby="v-pills-color-tab" tabindex="0">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="color1" />
                            <label class="form-check-label" for="color1">Black</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="color2" />
                            <label class="form-check-label" for="color2">Gray</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="color3" />
                            <label class="form-check-label" for="color3">Blue</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="color4" />
                            <label class="form-check-label" for="color4">Yellow</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="color5" />
                            <label class="form-check-label" for="color5">Green</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="color6" />
                            <label class="form-check-label" for="color6">Red</label>
                        </div>
                    </div>

                    <div class="tab-pane price-info fade" id="v-pills-price" role="tabpanel" aria-labelledby="v-pills-price-tab" tabindex="0">
                        <div class="range-slider">
                            <span>From <input type="number" value="250" min="0" max="100000" step="50" /> To <input type="number" value="750" min="0" max="1000" step="50" /> </span>
                            <input value="250" min="0" max="1000" step="50" type="range" />
                            <input value="500" min="0" max="1000" step="50" type="range" />
                            <svg width="100%" height="24">
                                <line x1="4" y1="0" x2="480" y2="0" stroke="#444" stroke-width="12" stroke-dasharray="1 28"></line>
                            </svg>
                        </div>
                    </div>

                    <div class="tab-pane tab-info fade" id="v-pills-material" role="tabpanel" aria-labelledby="v-pills-material-tab" tabindex="0">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1" />
                            <label class="form-check-label" for="flexRadioDefault1">Fabric</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault2" checked />
                            <label class="form-check-label" for="flexRadioDefault2">Wooden</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault3" />
                            <label class="form-check-label" for="flexRadioDefault2">Metal</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault4" />
                            <label class="form-check-label" for="flexRadioDefault1">Plastic</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault5" />
                            <label class="form-check-label" for="flexRadioDefault2">Glass</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-modal d-flex gap-3">
                <a href="landing" class="btn gray-btn btn-inline mt-0 w-50">Clear Filter</a>
                <a href="landing" class="theme-btn btn btn-inline mt-0 w-50" data-bs-dismiss="modal">apply</a>
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
        <li class="active">
            <a href="{{route('mobile.marketplace.index')}}">
                <div class="icon">
                    <img class="unactive" src="{{asset('mobile/images/svg/home.svg')}}" alt="home" />
                    <img class="active" src="{{asset('mobile/images/svg/home-fill.svg')}}" alt="home" />
                </div>
            </a>
        </li>
        <li>
            <a href="categories">
                <div class="icon">
                    <img class="unactive" src="{{asset('mobile/images/svg/categories.svg')}}" alt="categories" />
                    <img class="active" src="{{asset('mobile/images/svg/categories-fill.svg')}}" alt="categories" />
                </div>
            </a>
        </li>
        <li>
            <a href="cart">
                <div class="icon">
                    <img class="unactive" src="{{asset('mobile/images/svg/bag.svg')}}" alt="bag" />
                    <img class="active" src="{{asset('mobile/images/svg/bag-fill.svg')}}" alt="bag" />
                </div>
            </a>
        </li>
        <li>
            <a href="wishlist">
                <div class="icon">
                    <img class="unactive" src="{{asset('mobile/images/svg/heart.svg')}}" alt="heart" />
                    <img class="active" src="{{asset('mobile/images/svg/heart-fill.svg')}}" alt="heart" />
                </div>
            </a>
        </li>
        @guest()
            <li>
                <a href="{{route('mobile.login')}}">
                    <div class="icon">
                        <img class="unactive" src="{{asset('mobile/images/svg/profile.svg')}}" alt="profile" />
                        <img class="active" src="{{asset('mobile/images/svg/profile-fill.svg')}}" alt="profile" />
                    </div>
                </a>
            </li>
        @else

            <li>
                <a href="{{route('user.settings.index')}}">
                    <div class="icon">
                        <img class="unactive" src="{{asset('mobile/images/svg/profile.svg')}}" alt="profile" />
                        <img class="active" src="{{asset('mobile/images/svg/profile-fill.svg')}}" alt="profile" />
                    </div>
                </a>
            </li>
        @endguest
    </ul>
</div>
<!-- bottom navbar end -->
