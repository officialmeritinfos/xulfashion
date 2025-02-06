@extends('mobile.users.layout.plainBase')
@section('content')

    <!-- profile setting section start -->
    <form class="theme-form profile-setting mt-5" action="{{route('mobile.user.profile.edit.process')}}" method="post" id="basicSettings"
    enctype="multipart/form-data">
        @csrf
        <div class="custom-container">
            <div class="form-group d-block">
                <label for="inputname" class="form-label">Name</label>
                <div class="form-input mb-4">
                    <input type="text" class="form-control" id="inputname" value="{{$user->name}}" name="name" />
                    <i class="iconsax icons" data-icon="user-1"></i>
                </div>
            </div>

            <div class="form-group d-block">
                <label for="inputuseremail" class="form-label">Email</label>
                <div class="form-input mb-4">
                    <input type="email" class="form-control" id="inputuseremail" value="{{$user->email}}" name="email" readonly/>
                    <i class="iconsax icons" data-icon="mail"></i>
                </div>
            </div>

            <div class="form-group d-block">
                <label for="inputusernumber" class="form-label">Phone Number</label>
                <div class="form-input">
                    <input type="text" class="form-control" id="inputusernumber" value="{{$user->phone}}" name="phone"/>
                    <i class="iconsax icons" data-icon="phone"></i>
                </div>
            </div>

            <div class="form-group d-block mt-3">
                <label for="inputusernumber" class="form-label">Photo</label>
                <div class="form-input">
                    <input type="file" class="form-control" id="inputusernumber" name="image" accept="image/*"/>
                    <i class="iconsax icons" data-icon="picture-upload"></i>
                </div>
            </div>
            <div class="footer-modal d-flex gap-3 justify-content-center">
                <button type="submit" class="theme-btn btn btn-inline mt-0 w-50 submit">Save</button>
            </div>
        </div>
    </form>
    <!-- profile setting section end -->


    @push('js')
        <script src="{{asset('mobile/js/requests/profile-edit.js?ver=1.0')}}"></script>
    @endpush
@endsection
