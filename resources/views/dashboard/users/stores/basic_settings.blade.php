@extends('dashboard.layout.base')
@section('content')

    <div class="container-fluid">
        <form id="processForm" action="{{route('user.stores.edit.settings.process',['id'=>$store->reference])}}" method="post"
              enctype="multipart/form-data">
            @csrf

            <div class="submit-property-form product-upload mt-3">
                <div class="row">

                    <div class="col-md-12">
                        <div class="col-md-12 mt-3">
                            <div class="col-md-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" value="1" type="checkbox" id="sales"
                                           name="notifications"
                                        {{($settings->allowNotifications==1)?'checked':''}}>
                                    <label class="form-check-label" for="sales">
                                        Receive notifications
                                        <i class="ri-information-fill" data-bs-toggle="tooltip"
                                           title="Receive notifications for activities done by customers on your store."></i>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" value="1" type="checkbox" id="cancelledSub"
                                           name="newsletter"
                                        {{($settings->allowNewLetters==1)?'checked':''}}>
                                    <label class="form-check-label" for="cancelledSub">
                                        Allow Newletters signup
                                        <i class="ri-information-fill" data-bs-toggle="tooltip"
                                           title="Allow your customers to join newletters on your store - that is if you offer one."></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" value="1" type="checkbox" id="failedSubCharge"
                                           name="signups"
                                        {{($settings->allowSignups==1)?'checked':''}}>
                                    <label class="form-check-label" for="failedSubCharge">
                                        Allow signups on store
                                        <i class="ri-information-fill" data-bs-toggle="tooltip"
                                           title="This will automatically create an account for your customers on your store"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" value="1" type="checkbox" id="productRating"
                                           name="collectPhone"
                                        {{($settings->collectPhone==1)?'checked':''}}>
                                    <label class="form-check-label" for="productRating">
                                        Collect customer's phone number upon checkout
                                        <i class="ri-information-fill" data-bs-toggle="tooltip"
                                           title="In addition to other details which we will collect by default, your customers contact number will be required"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" value="1" type="checkbox" id="productRatings"
                                           name="collectPayment"
                                        {{($settings->allowOnlineCheckout==1)?'checked':''}}>
                                    <label class="form-check-label" for="productRatings">
                                        Allow your customers to pay online
                                        <i class="ri-information-fill" data-bs-toggle="tooltip"
                                           title="By default, your customers pay online - you can however turn this option off and they will have to contact your
                                           for their orders. If your business is not verified, payments received will be kept pending and not released to your  until
                                           you have verified your business."></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" value="1" type="checkbox" id="whatsappPayment"
                                           name="whatsappPayment"
                                        {{($settings->allowWhatsappCheckout==1)?'checked':''}}>
                                    <label class="form-check-label" for="whatsappPayment">
                                        Allow your customers to checkout on Whatsapp
                                        <i class="ri-information-fill" data-bs-toggle="tooltip"
                                           title="This allows your customers to be redirected to Whatsapp where they can complete their purchase."></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 whatsappContact mt-3" style="display: none;">
                                <label for="inputState" class="form-label">Whatsapp Number<sup class="text-danger">*</sup> <i class="ri-information-fill"
                                    data-bs-toggle="tooltip" title="The Whatsapp number where your users will be redirected to including the country code. e.g
                                    234902345786"></i> </label>
                                <input type="text" class="form-control" id="price" placeholder="Whatsapp contact" name="whatsappNumber" value="{{$settings->whatsappContact}}">
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" value="1" type="checkbox" id="whatsappSupport"
                                           name="whatsappSupport"
                                        {{($settings->whatsappSupport==1)?'checked':''}}>
                                    <label class="form-check-label" for="whatsappSupport">
                                        Offer Whatsapp Support
                                        <i class="ri-information-fill" data-bs-toggle="tooltip"
                                           title="This is your helpdesk for customers on Whatsapp. Activate it to enable your customers to contact you on whatsapp."></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 whatsappSupport mt-3">
                                <label for="inputState" class="form-label">Whatsapp Support Number<sup class="text-danger">*</sup>
                                    <i class="ri-information-fill"
                                       data-bs-toggle="tooltip" title="The Whatsapp number where your users will be redirected to including the country code. e.g
                                    234902345786"></i> </label>
                                <input type="text" class="form-control" id="price" placeholder="Whatsapp contact" name="whatsappSupportNumber"
                                value="{{$settings->whatsappSupportNumber}}">
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" value="1" type="checkbox" id="escrowPayment"
                                           name="escrowPayment"
                                        {{($settings->allowEscrowPayments==1)?'checked':''}}>
                                    <label class="form-check-label" for="escrowPayment">
                                        Enable Escrow Checkout
                                        <i class="ri-information-fill" data-bs-toggle="tooltip"
                                           title="Enable escrow payment. Escrow payment helps you build confidence in your customer such that you will
                                           deliver what they have paid. Payments received are held in confidence until order has been fulfilled. "></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 price mt-3">
                                <label for="inputState" class="form-label">Default Buy Text<sup class="text-danger">*</sup>
                                    <i class="ri-information-fill"
                                       data-bs-toggle="tooltip" title="This text will display instead of the default Add to cart text"></i> </label>
                                <input type="text" class="form-control" id="price" placeholder="Default Add to Cart Text" name="defaultBuyText"
                                value="{{$settings->defaultBuyText}}">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="text-center mt-5">
                    <button type="submit"
                            class="btn btn-outline-success rounded submit">
                        Update settings
                    </button>
                </div>
            </div>

        </form>
    </div>

    @push('js')
        <script>
            $(function (){
                $('input[name="whatsappPayment"]').on('click',function (){
                    if($('input[name="whatsappPayment"]').is(':checked')){
                        $('.whatsappContact').show();
                    }else{
                        $('.whatsappContact').hide();
                    }
                });
                $('input[name="whatsappSupport"]').on('click',function (){
                    if($('input[name="whatsappSupport"]').is(':checked')){
                        $('.whatsappSupport').show();
                    }else{
                        $('.whatsappSupport').hide();
                    }
                });
            });
            if($('input[name="whatsappPayment"]').is(':checked')){
                $('.whatsappContact').show();
            }else{
                $('.whatsappContact').hide();
            }
            if($('input[name="whatsappSupport"]').is(':checked')){
                $('.whatsappSupport').show();
            }else{
                $('.whatsappSupport').hide();
            }
        </script>
        <script src="{{asset('requests/dashboard/user/stores.js')}}"></script>
    @endpush
@endsection
