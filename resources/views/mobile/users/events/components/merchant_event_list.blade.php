@foreach($events as $event)
    <div class="col-6">
        <div class="product-box">
            <div class="product-box-img">
                <a href="product-details.html"> <img class="img" src="{{$event->featuredImage}}" alt="p1" /></a>

                <div class="cart-box">
                    <a href="cart.html" class="cart-bag">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="product-box-detail">
                <h4>{{$event->title}}</h4>
                <h5>{{eventCategoryById($event->category)->name}}</h5>
                <div class="bottom-panel d-flex flex-wrap align-items-center">
                    <div class="price me-3 mb-2">
                        <h4 class="mb-0">
                            {{ eventType($event->eventType) }}
                        </h4>
                    </div>
                    <div class="rating">
                        <h6>Status: </h6>
                        <h6>
                            @switch($event->status)
                                @case(1)
                                    <i class="fa fa-check-circle text-success" style="font-size: 14px;"
                                       data-bs-toggle="tooltip" title="Active"></i>
                                    @break
                                @case(2)
                                    <i class="fa fa-rotate-270 fa-rotate text-primary" style="font-size: 14px;"
                                       data-bs-toggle="tooltip" title="Review"></i>
                                    @break
                                @case(3)
                                    <i class="fa fa-ban text-danger" style="font-size: 14px;"
                                       data-bs-toggle="tooltip" title="Cancelled"></i>
                                    @break
                                @default
                                    <i class="fa fa-warning text-danger" style="font-size: 14px;"
                                       data-bs-toggle="tooltip" title="Rejected"></i>
                                    @break
                            @endswitch
                        </h6>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endforeach
