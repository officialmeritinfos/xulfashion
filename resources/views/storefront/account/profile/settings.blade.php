@extends('storefront.account.layouts.base')
@section('content')
    @inject('injected','App\Custom\Regular')

    <div class="submit-property-area">
        <div class="container-fluid">
            <form class="submit-property-form" id="processForm" method="post" action="{{route('merchant.store.settings.process',['subdomain'=>$subdomain,'customer'=>$customer->id])}}">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" class="form-control" placeholder="Enter your full name" name="name" value="{{$customer->name}}">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" class="form-control" placeholder="Enter your email" name="email" value="{{$customer->email}}" disabled>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" placeholder="Enter your phone number" name="phone" value="{{$customer->phone}}">
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Bio</label>
                            <textarea class="form-control" placeholder="Enter your bio" name="bio">{{$customer->bio}}</textarea>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Country</label>
                            <select class="form-control" name="country" id="floatingCountry">
                                @foreach($countries as $country)
                                    <option value="{{$country->iso3}}" {{($country->iso3==$customer->country)?'selected':''}}
                                    data-url="{{route('fetch.country.state',['subdomain'=>$subdomain,'id'=>$country->iso2])}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>State</label>
                            <select type="text" class="form-control floatingState" name="state"></select>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" placeholder="Enter your address" name="address">{{$customer->address}}</textarea>
                        </div>
                    </div>

                    <div class="col-lg-12 text-center">
                        <button type="submit" class="default-btn submit">
                            Save Change
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    @if($customer->password==null)
        <div class="submit-property-area mt-4">
            <div class="container-fluid text-center">
               <div class="ui-kit-card">
                   <button class="btn btn-outline-primary" data-bs-target="#setupPassword" data-bs-toggle="modal">Setup Password</button>
               </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="setupPassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Setup Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="submit-property-form" id="processPasswordSetup" method="post"
                              action="{{route('merchant.store.settings.process.password.setup',['subdomain'=>$subdomain,'customer'=>$customer->id])}}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" placeholder="Enter password" name="password"/>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Password Confirmation</label>
                                        <input type="password" class="form-control" placeholder="Repeat password" name="password_confirmation"/>
                                    </div>
                                </div>


                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="default-btn submit">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    @else
        <div class="submit-property-area mt-4">
            <div class="container-fluid">
                <form class="submit-property-form col-md-8 mx-auto" id="processPasswordSetup" method="post"
                      action="{{route('merchant.store.settings.process.password',['subdomain'=>$subdomain,'customer'=>$customer->id])}}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Old Password<sup class="text-danger">*</sup></label>
                                <input type="password" class="form-control form-control-lg password" placeholder="Enter your current password"
                                       name="oldPassword">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>New password <sup class="text-danger">*</sup></label>
                                <input type="password" class="form-control form-control-lg password" placeholder="Enter your new password"
                                       name="newPassword">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Repeat New Password <sup class="text-danger">*</sup></label>
                                <input type="password" class="form-control form-control-lg password" placeholder="Repeat your new password"
                                       name="newPassword_confirmation">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="login-action">
                            <span class="forgot-login toggle-btn">
                                Show Password
                            </span>
                            </div>
                        </div>


                        <div class="col-lg-12 text-center">
                            <button type="submit" class="default-btn submit">
                                Save Change
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endempty


    @push('js')
        <script>
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

            $(function (){
                var countryIso3 = $('#floatingCountry').val();
                var url = $('#floatingCountry').find('option:selected').data('url');

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
        </script>
        <script src="{{asset('requests/dashboard/user/stores.js')}}"></script>
        <script src="{{asset('requests/dashboard/password.js')}}"></script>

    @endpush
@endsection
