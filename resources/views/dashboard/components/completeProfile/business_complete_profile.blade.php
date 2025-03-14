<form id="tutorData" style="display: none;" method="post" action="{{route('complete-account-setup.process.seller')}}"
class="submit-property-form product-upload shadow-none" enctype="multipart/form-data">
    <div class="col-md-12 row g-3">
        @csrf
        <div class="col-md-12" id="frontImage">
            <label for="inputAddress" class="form-label">
                Image <i class="ri-information-fill" data-bs-toggle="tooltip"
                         title="This is a public image, and will serve as your profile picture. Make sure the image you
                         upload corresponds with the image you will upload for KYC"></i><sup class="text-danger">*</sup>
            </label>
            <input type="file" class="form-control" id="inputAddress" name="image">
        </div>
        <div class="col-md-12">
            <label for="inputPassword4" class="form-label">Tell Us About yourself<i class="ri-information-fill" data-bs-toggle="tooltip"
                title="This is public. So make sure you properly tell your audience about yourself and what you do."></i> <sup class="text-danger">*</sup></label>
            <textarea type="date" class="form-control summernote" id="inputPassword4" name="bio">{{$user->bio}}</textarea>
        </div>
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Merchant Type<sup class="text-danger">*</sup></label>
            <select class="form-control selectize" id="inputEmail4" name="merchantType">
                <option value="">Select an Option</option>
                <option value="1" {{($user->merchantType=='1')?'selected':''}}>Retailer</option>
                <option value="2" {{($user->merchantType=='2')?'selected':''}}>Fashion Designer</option>
                <option value="3" {{($user->merchantType=='3')?'selected':''}}>Manufacturer</option>
                <option value="4" {{($user->merchantType=='4')?'selected':''}}>Model</option>
            </select>
        </div>

        <div class="col-md-6">
            <label for="inputAddress" class="form-label">
                Display Name <i class="ri-information-fill" data-bs-toggle="tooltip"
                                title="This will serve as your name on our marketplace. This does not replace your legal name as that will be used to
                                verify your identity"></i>
            </label>
            <input class="form-control" id="inputEmail4" name="displayName" value="{{$user->displayName}}"/>
        </div>
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Gender<sup class="text-danger">*</sup></label>
            <select class="form-control selectize" id="inputEmail4" name="gender">
                <option value="">Select your gender</option>
                <option value="male" {{($user->gender=='male')?'selected':''}}>Male</option>
                <option value="female" {{($user->gender=='female')?'selected':''}}>Female</option>
                <option value="others" {{($user->gender=='others')?'selected':''}}>Others</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputPassword4" class="form-label">Date of Birth<sup class="text-danger">*</sup></label>
            <input type="date" class="form-control" id="inputPassword4" name="dob" value="{{$user->dob}}">
        </div>
        <div class="col-12">
            <label for="inputAddress" class="form-label">Address <sup class="text-danger">*</sup></label>
            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address" value="{{$user->address}}">
        </div>
        <div class="col-md-12">
            <label for="inputAddress" class="form-label">
                Meta Tags <i class="ri-information-fill" data-bs-toggle="tooltip" title="Be more visible by tagging your profile with popular search keywords"></i>
            </label>
            <input class="form-control selectizeAdd" id="inputEmail4" name="tutorKeywords[]" value="{{$user->tutorKeywords}}"/>
        </div>

        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="activeForJob" value="1" name="activeForJob" checked>
                <label class="form-check-label" for="activeForJob">
                    Actively Looking for work? <i class="ri-information-fill" data-bs-toggle="tooltip" title="Are you actively looking for job?"></i>
                </label>
            </div>
        </div>
    </div>

    <div class="col-12 text-center mt-3">
        <button type="submit" class="default-btn submit">Complete Profile</button>
    </div>
</form>
