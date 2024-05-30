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
        <hr/>

            <div class="hstack align-items-center justify-content-between fw-bold text-content">
                <div class="mb-3">
                    <p>Checkout Type </p>
                    @if($userStoreSetting->allowWhatsappCheckout==1)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="checkoutType" id="inlineRadio1" value="1">
                            <label class="form-check-label" for="inlineRadio1">Whatsapp</label>
                        </div>
                    @endif
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="checkoutType" id="inlineRadio2" value="2"
                        {{($userStoreSetting->allowWhatsappCheckout!=1)?'checked':''}}>
                        <label class="form-check-label" for="inlineRadio2">Pay Online</label>
                    </div>
                </div>
            </div>
        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-dark btn-ecomm py-3 px-5 submit">Place Order</button>
        </div>
    </div>
</div>
