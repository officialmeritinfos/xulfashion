@extends('mobile.users.layout.plainBase')
@section('content')
    <div class="container-fluid">
        <!-- profile setting section start -->
        <form class="theme-form profile-setting" action="{{route('mobile.user.profile.settings.complete-profile.process')}}" method="post" id="basicSettings"
              enctype="multipart/form-data">
            @csrf
            <div class="form-group d-block mb-3">
                <label for="inputusernumber" class="form-label">
                    Image  <sup><i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                   title="This is a public image, and will serve as your profile picture. Make sure the image you
                             upload corresponds with the image you will upload for KYC"></i></sup><sup class="text-danger">*</sup>
                </label>
                <div class="form-input">
                    <input type="file" class="form-control form-control-lg" id="inputusernumber" name="image" accept="image/*"/>
                    <i class="iconsax icons" data-icon="picture-upload"></i>
                </div>
            </div>

            <div class="form-group d-block mb-3">
                <label for="inputname" class="form-label">
                    Tell Us About yourself <sup><i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                                   title="This is public. So make sure you properly tell your audience about yourself and what you do."></i></sup>
                    <sup class="text-danger">*</sup>
                </label>
                <div class="form-input mb-3">
                    <textarea type="text" class="form-control" id="inputname" name="bio">{{$user->bio}}</textarea>
                    <i class="iconsax icons" data-icon="user-1"></i>
                </div>
            </div>

            <div class="form-group d-block">
                <label for="inputusernumber" class="form-label">Merchant Type<sup class="text-danger">*</sup></label>
                <div class="form-input mb-4 position-relative">
                    <select class="form-control form-control-lg" id="merchantType" name="merchantType">
                        <option value="">Select an Option</option>
                        <option value="1" {{($user->merchantType=='1')?'selected':''}}>Retailer</option>
                        <option value="2" {{($user->merchantType=='2')?'selected':''}}>Fashion Designer</option>
                        <option value="3" {{($user->merchantType=='3')?'selected':''}}>Manufacturer</option>
                        <option value="4" {{($user->merchantType=='4')?'selected':''}}>Model</option>
                        <option value="5" {{($user->merchantType=='5')?'selected':''}}>Fashion School</option>
                    </select>
                    <i class="iconsax icons" data-icon="user-2"></i>
                </div>
            </div>

            <div class="form-group d-block mb-3">
                <label for="inputusernumber" class="form-label">
                    Display Name<sup>
                        <i class="fa fa-info-circle" data-bs-toggle="tooltip"
                           title="This will serve as your name on our marketplace. This does not replace your legal name as that will be used to
                                    verify your identity"></i>
                    </sup>
                </label>
                <div class="form-input">
                    <input type="text" class="form-control" id="inputusernumber" value="{{$user->displayName}}" name="displayName"/>
                    <i class="iconsax icons" data-icon="user-2"></i>
                </div>
            </div>

            <div class="form-group d-block mb-3">
                <label for="inputusernumber" class="form-label">Gender <sup class="text-danger">*</sup></label>
                <div class="form-input">
                    <select class="form-control form-control-lg" id="inputusernumber" name="gender">
                        <option value="">Select your gender</option>
                        <option value="male" {{($user->gender=='male')?'selected':''}}>Male</option>
                        <option value="female" {{($user->gender=='female')?'selected':''}}>Female</option>
                        <option value="others" {{($user->gender=='others')?'selected':''}}>Others</option>
                    </select>
                </div>
            </div>

            <div class="form-group d-block mb-3">
                <label for="inputusernumber" class="form-label">Date of Birth</label>
                <div class="form-input">
                    <input type="date" class="form-control" id="inputusernumber" value="{{$user->dob}}" name="dob"/>
                    <i class="iconsax icons" data-icon="calendar-2"></i>
                </div>
            </div>
            <div class="form-group d-block mb-3">
                <label for="inputname" class="form-label">
                    Address <sup><i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                                   title="Let us know your location, where you can be found etc"></i></sup>
                    <sup class="text-danger">*</sup>
                </label>
                <div class="form-input mb-3">
                    <textarea type="text" class="form-control" id="inputname" name="address">{{$user->bio}}</textarea>
                    <i class="iconsax icons" data-icon="map-1"></i>
                </div>
            </div>
            <div class="form-group d-block mb-3">
                <label for="inputname" class="form-label">
                    Keywords <sup><i class="fa fa-info-circle" data-bs-toggle="tooltip" title="Be more visible by tagging your profile with popular search keywords"></i></sup>
                </label>
                <div class="form-input mb-3">
                    <input type="text" class="selectizeAdd" id="inputname" name="tutorKeywords[]" multiple value="{{$user->tutorKeywords}}" />
                    <i class="iconsax icons" data-icon="ranking"></i>
                </div>
            </div>

            <div class="text-center mb-5">
                <button type="submit" class="btn btn-outline-primary mt-0 w-50 submit mb-3">Complete Profile</button>
            </div>
        </form>
        <!-- profile setting section end -->
    </div>


    @push('js')
        <script src="{{asset('mobile/js/requests/profile-edit.js')}}"></script>
    @endpush

@endsection
