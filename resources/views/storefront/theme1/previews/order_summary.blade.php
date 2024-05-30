<div class="card rounded-0 mb-3">
    <div class="card-body">
        <h5 class="fw-bold mb-4">Order Summary</h5>
        <div class="hstack align-items-center justify-content-between">
            <p class="mb-0">Bag Total</p>
            <p class="mb-0" id="bag-total">{{$sign}} {{ number_format($bagTotal,2) }}</p>
        </div>
        <hr>
        <div class="hstack align-items-center justify-content-between">
            <p class="mb-0">Bag Discount</p>
            <p class="mb-0 text-success" id="bag-discount">- {{$sign}} {{ number_format($discount,2) }}</p>
        </div>
        <hr>
        <div class="hstack align-items-center justify-content-between fw-bold text-content">
            <p class="mb-0">Total Amount</p>
            <p class="mb-0" id="total-amount">{{$sign}} {{ number_format($totalAmount,2) }}</p>
        </div>
        <div class="d-grid mt-4">
            <a href="{{route('merchant.store.checkout',['subdomain'=>$subdomain])}}" type="button" class="btn btn-dark btn-ecomm py-3 px-5 submit">Proceed To Checkout</a>
        </div>
    </div>
</div>
<div class="card rounded-0">
    <div class="card-body">
        <h5 class="fw-bold mb-4">Apply Coupon</h5>


        @if($hasCoupon)
            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0">Coupon Applied: <strong>{{ $couponCode }}</strong></p>
                <button class="btn btn-danger btn-sm remove-coupon submit" type="button"
                        data-url="{{ route('merchant.store.remove.coupon', ['subdomain' => $subdomain]) }}">Remove</button>
            </div>
        @else
            <div class="input-group">
                <input type="text" class="form-control rounded-0" placeholder="Enter coupon code" name="coupon">
                <button class="btn btn-dark btn-ecomm rounded-0 submit" type="button"
                        data-url="{{ route('merchant.store.add.coupon', ['subdomain' => $subdomain]) }}">Apply</button>
            </div>
        @endif
    </div>
</div>
