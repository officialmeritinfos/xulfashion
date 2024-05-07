@extends('dashboard.layout.base')
@section('content')

    <div class="product-area">
        <div class="container-fluid">
            @if($ads->count()<1)
                <div class="product-area">
                    <div class="container-fluid">

                        <div class="row" style="margin-top:10rem;">
                            <div class="col-xl-6 col-sm-6 mx-auto">
                                <div class=" shadow-none mb-3">
                                    <div class="card-body text-center">
                                        <a class="btn btn-outline-primary small-button" href="{{route('user.ads.new')}}">
                                            Create Ad
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <form class="search-bar d-flex">
                                <i class="ri-search-line"></i>
                                <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                            </form>
                        </div>
                    </div>
                    <div class="row" style="margin-top:1rem;">
                        <div class="col-xl-12 col-sm-12 mx-auto">
                            <div class=" shadow-none mb-3">
                                <div class="card-body text-center">
                                    <a href="{{route('user.ads.new')}}" class="btn btn-outline-primary small-button">
                                        Add New Ad
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($ads as $ad)
                        <div class="col-xl-3 col-sm-6">
                            <div class="single-products">
                                <div class="products-img">
                                    <img src="{{$ad->featuredImage}}" alt="Images">

                                    <div class="add-to-cart">
                                        <a href="{{route('user.ads.details',['id'=>$ad->reference])}}" class="default-btn">
                                            Details
                                            <i class="ri-arrow-right-line"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="products-content d-flex">
                                    <div class="product-title flex-grow-1">
                                        <h3>
                                            <a href="{{route('user.ads.details',['id'=>$ad->reference])}}">
                                                {{$ad->title}}
                                            </a>
                                        </h3>
                                        <span class="price">
                                            @if($ad->priceType==1)
                                                Contact for price
                                            @else
                                                {{$ad->currency}}{{number_format($ad->amount,2)}}
                                            @endif
                                        </span>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="dropdown ms-auto text-end">
                                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                                               data-bs-toggle="dropdown">
                                                <i class='bx bx-dots-horizontal-rounded font-22 text-option' .
                                                   style="font-size: 15px;"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{route('user.ads.edit',['id'=>$ad->reference])}}">
                                                        <i class="ri-edit-2-fill"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{route('user.ads.delete',['id'=>$ad->reference])}}">
                                                        <i class="ri-delete-bin-6-line"></i> Delete
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                        <span class="reviews">
                                            <ul>
                                                @switch($ad->status)
                                                        @case(1)
                                                            <li class="text-success" data-bs-toggle="tooltip" title="Active">
                                                           Status: <i class="ri-check-double-fill text-success" style="font-size: 20px;"></i>
                                                        </li>
                                                            @break
                                                        @case(2)
                                                            <li class="text-primary" data-bs-toggle="tooltip" title="Under-review">
                                                           Status: <i class="bx bx-loader-alt bx-spin text-primary" style="font-size: 20px;"></i>
                                                        </li>
                                                            @break
                                                        @case(3)
                                                            <li class="text-danger" data-bs-toggle="tooltip" title="Deactivated">
                                                           Status: <i class="ri-alert-fill text-danger" style="font-size: 20px;"></i>
                                                        </li>
                                                            @break
                                                        @default
                                                            <li class="text-danger" data-bs-toggle="tooltip" title="Rejected By support">
                                                           Status: <i class="ri-error-warning-fill text-danger" style="font-size: 20px;"></i>
                                                        </li>
                                                            @break
                                                    @endswitch
                                            </ul>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

@endsection
