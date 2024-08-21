@extends('mobile.ads.layout.innerBase')
@section('content')



    <!-- Categories section start -->
    <section class="mt-5">
        <div class="custom-container">
            <ul class="categories-list">

                @foreach($ads as $key=> $ad)
                    <li class="{{($key==0)?'mt-0':''}}">
                        <a href="{{route('mobile.marketplace.service',['id'=>$ad->serviceType])}}" class="d-flex align-items-center">
                            <div class="ps-3">
                                <h2>{{serviceTypeById($ad->serviceType)->name}}</h2>
                                <h4 class="mt-1">Total {{adsInService($ad->serviceType)}} Ads</h4>
                                <div class="arrow">
                                    <i class="iconsax right-arrow" data-icon="arrow-right"></i>
                                </div>
                            </div>
                            <div class="categories-img">
                                <img class="img-fluid img" src="{{$ad->featuredImage}}" alt="p3" />
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

@endsection
