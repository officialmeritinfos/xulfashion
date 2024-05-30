@extends('storefront.theme1.layout.base')
@section('content')
    @inject('options','App\Custom\Storefront')

    <!--start breadcrumb-->
    <div class="py-4 border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('merchant.store',['subdomain'=>$subdomain])}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('merchant.store.shop',['subdomain'=>$subdomain])}}">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <!--start product details-->
    <section class="section-padding">
        <div class="container">
            <div class="d-flex align-items-center px-3 py-2 border mb-4">
                <div class="text-start">
                    <h4 class="mb-0 h4 fw-bold">Billing Details</h4>
                </div>
            </div>
            <div class="row g-4">
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
            </div><!--end row-->

        </div>
    </section>
    <!--start product details-->

    @push('js')
        <script>
            $(document).ready(function() {

                $('#processCheckout').on('submit', function(event) {
                    event.preventDefault(); // Prevent default form submission

                    var form = $(this);
                    var actionUrl = form.attr('action');
                    var formData = form.serialize();

                    $.ajax({
                        url: actionUrl,
                        type: 'POST',
                        data: formData,
                        beforeSend:function(){
                            $('.submit').attr('disabled', true);
                            $(".submit").LoadingOverlay("show",{
                                text        : "processing...",
                                size        : "20"
                            });
                        },
                        success:function(data)
                        {
                            if(data.error===true)
                            {
                                toastr.options = {
                                    "closeButton" : true,
                                    "progressBar" : true
                                }
                                toastr.error(data.data.error);

                                //return to natural stage
                                setTimeout(function(){
                                    $('.submit').attr('disabled', false);
                                    $(".submit").LoadingOverlay("hide");
                                    $("#processCheckout :input").prop("readonly", false);
                                }, 3000);
                            }
                            if(data.error === 'ok')
                            {
                                toastr.options = {
                                    "closeButton" : true,
                                    "progressBar" : true
                                }
                                toastr.info(data.message);

                                setTimeout(function(){
                                    $('.submit').attr('disabled', false);
                                    $(".submit").LoadingOverlay("hide");
                                    $("#processCheckout :input").prop("readonly", false);
                                    window.location.replace(data.data.redirectTo)
                                }, 5000);
                            }
                        },
                        error:function (jqXHR, textStatus, errorThrown){
                            toastr.options = {
                                "closeButton" : true,
                                "progressBar" : true
                            }
                            toastr.error(jqXHR.responseJSON.data.error);
                            $("#processCheckout :input").prop("readonly", false);
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                        },
                    });
                });

                function loadOrderSummary() {
                    $.ajax({
                        url: '{{ route("merchant.store.checkout.summary.checkout",['subdomain'=>$subdomain]) }}',
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $('#order-summary-container').html(response.html);
                            }
                        },
                        error: function(error) {
                            console.log('Error fetching order summary:', error);
                        }
                    });
                }
                loadOrderSummary();

                $('#floatingCountry').on('change', function() {
                    var countryIso3 = $(this).val();
                    var url = $(this).find('option:selected').data('url');

                    if (countryIso3 && url) {
                        $.ajax({
                            url: url,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('.floatingState').empty();
                                $('.floatingState').append('<option value="">Select State</option>');
                                $.each(data, function(key, value) {
                                    $('.floatingState').append('<option value="' + value.iso2 + '">' + value.name + '</option>');
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    } else {
                        $('.floatingState').empty();
                        $('.floatingState').append('<option value="">Select State</option>');
                    }
                });
            });
        </script>
    @endpush

@endsection
