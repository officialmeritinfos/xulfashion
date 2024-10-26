
@foreach($events as $event)
    <div class="col-6">
        <div class="product-box">
            <div class="product-box-img">
                <a href="{{route('mobile.marketplace.events.detail',['slug'=>textToSlug($event->title),'id'=>$event->reference])}}"> <img class="img" src="{{$event->featuredImage}}" alt="" /></a>

                <div class="cart-box">
                    <a href="{{route('mobile.marketplace.events.detail',['slug'=>textToSlug($event->title),'id'=>$event->reference])}}" class="cart-bag">
                        <i class="fa fa-arrow-right" data-icon="basket-2"></i>
                    </a>
                </div>
            </div>

            <div class="product-box-detail">
                <h4>{{$event->title}}</h4>
                <div class="d-flex justify-content-between gap-3">
                    <h5>{!! shortenText($event->description,5) !!}</h5>
                    <h3 class="fw-semibold">
                        {{{getStateFromIso2($event->state,$event->country)->name}}}
                    </h3>
                </div>
            </div>
        </div>
    </div>
@endforeach
