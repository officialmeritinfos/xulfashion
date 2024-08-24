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
                @auth('customers')
                    @include('storefront.theme1.previews.checkout_authenticated')
                @else
                    @include('storefront.theme1.previews.checkout_guest')
                @endauth
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
