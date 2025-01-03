@extends('mobile.users.layout.base')
@section('content')
    <div class="container-fluid mt-4">
        <!-- profile setting section start -->
        <form class="theme-form profile-setting" action="{{route('mobile.user.ads.edit.process')}}" method="post" id="basicSettings"
              enctype="multipart/form-data">
            @csrf
            <div class="form-group d-block">
                <label for="inputusernumber" class="form-label">Location<sup class="text-danger">*</sup></label>
                <div class="form-input mb-4 position-relative">
                    <select class="selectize" name="location">
                        <option value="">Select a Location</option>
                        @foreach($states as $state)
                            <option value="{{$state->iso2}}" {{($ad->state==$state->iso2)?'selected':''}}>{{$state->name}}</option>
                        @endforeach
                    </select>
                    <i class="iconsax icons" data-icon="map-2"></i>
                </div>
            </div>
            <div class="form-group d-block mb-3">
                <label for="inputusernumber" class="form-label">
                    Featured Photo  <sup><i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                            title="This is the photo that will first be seen by your customers - it should represent what
                                            you are posting else it will be rejected by compliance."></i></sup>
                </label>
                <div class="form-input">
                    <input type="file" class="form-control form-control-lg" id="inputusernumber" name="featuredPhoto" accept="image/*"/>
                    <i class="iconsax icons" data-icon="picture-upload"></i>
                </div>
            </div>
            <div class="form-group d-block mb-3">
                <label for="inputusernumber" class="form-label">
                    Ad Title<sup>
                        <i class="fa fa-info-circle" data-bs-toggle="tooltip"
                           title="A good name attracts more views, and higher views results to more leads."></i> <span class="text-danger">*</span>
                    </sup>
                </label>
                <div class="form-input">
                    <input type="text" class="form-control" id="inputusernumber" placeholder="My AD" name="title" value="{{$ad->title}}"/>
                    <i class="fa fa-note-sticky"></i>
                </div>
            </div>
            <div class="form-group d-block mb-3">
                <label for="inputusernumber" class="form-label">
                    Company Name<sup>
                        <i class="fa fa-info-circle" data-bs-toggle="tooltip"
                           title="if you are a manufacturer, you need to fill out this field. It is optional for others."></i>
                    </sup>
                </label>
                <div class="form-input">
                    <input type="text" class="form-control" id="inputusernumber" placeholder="AD LLC" name="companyName" value="{{$ad->companyName}}"/>
                    <i class="fa fa-building"></i>
                </div>
            </div>

            <div class="form-group d-block">
                <label for="inputusernumber" class="form-label">Category<sup class="text-danger">*</sup></label>
                <div class="form-input mb-4 position-relative">
                    <select class="selectize" id="merchantType" name="category">
                        <option value="">Select a Category</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" {{($ad->serviceType==$category->id)?'selected':''}}>{{$category->name}}</option>
                        @endforeach
                    </select>
                    <i class="fa fa-filter"></i>
                </div>
            </div>

            <div class="form-group d-block mb-3">
                <label for="inputname" class="form-label">
                    Description <sup><i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                        title="Write a very convincing description for your AD. This informs the viewers more about what this Ad
                                                   is about, the service you are offering, and keeps them engaged the more."></i></sup>
                    <sup class="text-danger">*</sup>
                </label>
                <div class="form-input mb-3">
                    <textarea type="text" class="form-control" id="inputname" name="description">{{$ad->description}}</textarea>
                    <i class="fa fa-file-alt"></i>
                </div>
            </div>

            <div class="form-group d-block mb-3">
                <label for="inputname" class="form-label">
                    Pricing Method <sup><i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                           title="How would you price your service? Contact for price or reveal thr price"></i></sup>
                    <sup class="text-danger">*</sup>
                </label>
                <div class="form-input mb-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="priceType" id="priceType" value="1" {{($ad->priceType==1)?'checked':''}}>
                        <label class="form-check-label" for="priceType">Contact for Price</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="priceType" id="priceType2" value="2" {{($ad->priceType==2)?'checked':''}}>
                        <label class="form-check-label" for="priceType2">Specify Price</label>
                    </div>
                    <div class="col-md-12 price mt-2">
                        <input type="text" class="form-control" id="price" placeholder="Price" name="price" value="{{$ad->amount}}">
                    </div>
                </div>
            </div>

            <div class="form-group d-block mb-3 negotiate">
                <label for="inputname" class="form-label">
                    Are you open to negotiation? <sup><i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                                         title="Are you open to negotiations?"></i></sup>
                    <sup class="text-danger">*</sup>
                </label>
                <div class="form-input mb-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="negotiate" id="negotiate" value="1" {{($ad->openToNegotiation==1)?'checked':''}}>
                        <label class="form-check-label" for="negotiate">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="negotiate" id="negotiate2" value="2" {{($ad->openToNegotiation==2)?'checked':''}}>
                        <label class="form-check-label" for="negotiate2">No</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="negotiate" id="negotiate2" value="3" {{($ad->openToNegotiation==3)?'checked':''}}>
                        <label class="form-check-label" for="negotiate2">Not Sure</label>
                    </div>
                </div>
            </div>

            <div class="form-group d-block mb-3">
                <label for="inputusernumber" class="form-label">
                    Photos  <sup><i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                    title="Add up to {{$web->fileUploadAllowed}} images which represents this AD. If you have only one photo which had been used
                                            as featured photo, please upload it again here."></i></sup><sup class="text-danger">*</sup>
                </label>
                <div class="form-input">
                    <input type="file" class="form-control form-control-lg" id="inputusernumber" name="photos[]" multiple accept="image/*"/>
                    <i class="fa fa-images"></i>
                </div>
            </div>

            <div class="form-group d-block mb-3">
                <label for="inputname" class="form-label">
                    Tags <sup><i class="fa fa-info-circle" data-bs-toggle="tooltip" title="Provide similar tags that can be used for your Ads.
                    Clients most times search based on keywords. After typeing the word, click enter to add more tags"></i></sup>
                </label>
                <div class="form-input mb-3">
                    <input type="text" class="selectizeAdd" id="inputname" name="tags[]" value="{{$ad->tags}}" />
                    <i class="iconsax icons" data-icon="ranking"></i>
                </div>
            </div>

            <div class="form-group d-block mb-3 d-none">
                <label for="inputname" class="form-label">
                    ADS
                </label>
                <div class="form-input mb-3">
                    <input type="text" class="form-control" id="inputname" name="ad" value="{{$ad->reference}}" />
                    <i class="iconsax icons" data-icon="ranking"></i>
                </div>
            </div>


            <div class="text-center mb-5">
                <button type="submit" class="btn btn-outline-primary mt-0 w-50 submit mb-3 btn-auto">Update Ad</button>
            </div>
        </form>
    </div>


    @push('js')
        <script>
            $(document).ready(function() {
                function togglePriceFields() {
                    let values = $('input[name="priceType"]:checked').val(); // Check for radio button selection

                    if (Number(values) === 2) {
                        $('.price').show();
                        $('.negotiate').show();
                    } else {
                        $('.price').hide();
                        $('.negotiate').hide();
                    }
                }

                // Run on page load
                togglePriceFields();

                // Run on change of priceType input
                $('input[name="priceType"]').on('change', togglePriceFields);
            });

        </script>
        <script src="{{asset('mobile/js/requests/profile-edit.js')}}"></script>
    @endpush
@endsection
