<form class="row g-4" id="processCheckout" action="{{route('merchant.store.checkout.process.authenticated',['subdomain'=>$subdomain])}}" method="post">
    @csrf
    <div class="col-12 col-lg-8 col-xl-8">
        <div class="card rounded-0">
            <div class="card-header bg-light">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-0">Saved Address</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h6 class="fw-bold mb-3 py-2 px-3 bg-light">Default Address</h6>
                <div class="card rounded-0 mb-3">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-xl-row gap-3">
                            <div class="address-info form-check flex-grow-1">
                                <input class="form-check-input" type="radio" name="flexRadioDefaultAddress" id="flexRadioDefaultAddress1" checked>
                                <label class="form-check-label" for="flexRadioDefaultAddress1">
                                    <span class="fw-bold mb-0 h5">{{auth('customers')->user()->name}}</span><br>
                                    {{auth('customers')->user()->address}} <br>
                                    {{auth('customers')->user()->city}},
                                     {{getStateFromCountryIso3(auth('customers')->user()->state,auth('customers')->user()->country)->name??'N/A'}}
                                        {{getCountryFromIso3(auth('customers')->user()->country)->name??'N/A'}}<br>
                                    @if(!empty(auth('customers')->user()->phone))
                                        Mobile: <span class="fw-bold">
                                            {{auth('customers')->user()->phone}}
                                        </span>
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4 col-xl-4" id="order-summary-container">

    </div>
</form>
