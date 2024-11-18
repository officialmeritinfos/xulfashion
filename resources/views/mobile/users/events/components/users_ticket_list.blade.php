@foreach($purchases as $purchase)
    <div class="col-md-6 col-12">
        <div class="product-box">
            <!-- Product Box Image -->
            <div class="product-box-img">
                <a href="{{ route('mobile.user.events.purchase.detail',['purchase'=>$purchase->reference]) }}">
                    <img class="img" src="{{ $purchase->events->featuredImage ??asset('home/main/img/feature/event.svg') }}" alt="Event Image" />
                </a>

                <!-- Cart Box -->
                <div class="cart-box">
                    <a href="{{ route('mobile.user.events.purchase.detail',['purchase'=>$purchase->reference]) }}" class="cart-bag">
                        <i class="iconsax bag fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Product Box Details -->
            <div class="product-box-detail">
                <h4>{{ $purchase->events->title }}</h4>
                <h5>{!! shortenText($purchase->events->description,50) !!}</h5>
                <div class="bottom-panel">
                    <!-- Price Section -->
                    <div class="price">
                        <h4>{{ currencySign($purchase->purchaseCurrency) . number_format($purchase->price, 2) }}</h4>
                    </div>
                    <!-- Status Section -->
                    <div class="status">
                            <span class="badge {{ $purchase->paymentStatus == 1 ? 'bg-success' : ($purchase->paymentStatus == 2 ? 'bg-warning' : 'bg-danger') }}">
                                {{ $purchase->paymentStatus == 1 ? 'Paid' : ($purchase->paymentStatus == 2 ? 'Pending' : 'Failed') }}
                            </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
