<form class="row g-4" id="processCheckout" action="{{route('merchant.store.checkout.process',['subdomain'=>$subdomain])}}" method="post">
    @csrf
    <div class="col-12 col-lg-8 col-xl-8">
        <h6 class="fw-bold mb-3 py-2 px-3 bg-light">Personal Details</h6>
        <div class="card rounded-0 mb-3">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-lg-12">
                        <div class="form-floating">
                            <input type="text" class="form-control rounded-0" id="floatingFirstName" placeholder="FUll Name"
                                   name="name">
                            <label for="floatingFirstName">Name<sup class="text-danger">*</sup></label>
                        </div>
                    </div>
                    <div class="col-12 {{($userStoreSetting->collectPhone==1)?'col-lg-6':'col-lg-12'}}">
                        <div class="form-floating">
                            <input type="text" class="form-control rounded-0" id="floatingEmail" placeholder="Email"
                                   name="email">
                            <label for="floatingEmail">Email<sup class="text-danger">*</sup></label>
                        </div>
                    </div>

                    @if($userStoreSetting->collectPhone==1)
                        <div class="col-12 col-lg-6">
                            <div class="form-floating">
                                <input type="text" class="form-control rounded-0" id="floatingMobileNo" placeholder="Mobile No"
                                       name="phone">
                                <label for="floatingMobileNo">Mobile No <sup class="text-danger">*</sup></label>
                            </div>
                        </div>
                    @endif
                </div><!--end row-->
            </div>
        </div>

        <h6 class="fw-bold mb-3 py-2 px-3 bg-light">Shipping Details</h6>
        <div class="card rounded-0">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-lg-12">
                        <div class="form-floating">
                                            <textarea class="form-control rounded-0" id="floatingStreetAddress" placeholder="Street Address"
                                                      name="address"></textarea>
                            <label for="floatingStreetAddress">Street Address<sup class="text-danger">*</sup></label>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="form-floating">
                            <select type="text" class="form-control rounded-0" id="floatingCountry" name="country">
                                <option value="">Select an Option</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->iso3}}" data-url="{{route('fetch.country.state',['subdomain'=>$subdomain,'id'=>$country->iso2])}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                            <label for="floatingCountry">Country <sup class="text-danger">*</sup> </label>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="form-floating">
                            <select class="form-control rounded-0 floatingState" id="floatingZipCode"
                                    name="state"></select>
                            <label for="floatingZipCode">State<sup class="text-danger">*</sup></label>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="form-floating">
                            <input type="text" class="form-control rounded-0" id="floatingCity" placeholder="City"
                                   name="city">
                            <label for="floatingCity">City<sup class="text-danger">*</sup></label>
                        </div>
                    </div>
                </div><!--end row-->
            </div>
        </div>


    </div>
    <div class="col-12 col-lg-4 col-xl-4" id="order-summary-container">

    </div>
</form>
