<form id="parentData" style="display: none;" method="post" action="{{route('complete-account-setup.process.parent')}}" enctype="multipart/form-data">
    <div class="col-md-12 row g-3">
        <div class="col-md-12" id="frontImage">
            <label for="inputAddress" class="form-label">
                Image <i class="ri-information-fill" data-bs-toggle="tooltip"
                         title="For the safety of our users, we need your photo. This will be used to while verifying your KYC alongside other details"></i><sup class="text-danger">*</sup>
            </label>
            <input type="file" class="form-control" id="inputAddress" name="image">
        </div>
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Gender<sup class="text-danger">*</sup></label>
            <select class="form-control selectize" id="inputEmail4" name="gender">
                <option value="">Select your gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="others">Others</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputAddress" class="form-label">Occupation <sup class="text-danger">*</sup></label>
            <input type="text" class="form-control" id="inputAddress" placeholder="Your main source of income" name="occupation">
        </div>
        <div class="col-12">
            <label for="inputAddress" class="form-label">Address <sup class="text-danger">*</sup></label>
            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address">
        </div>
        <div class="col-md-6">
            <label for="inputCity" class="form-label">Payment Rate ({{$user->mainCurrency}}) <sup class="text-danger">*</sup></label>
            <input type="number" step="0.01" class="form-control" id="inputCity" name="payRate">
        </div>
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Salary Type <i class="ri-information-fill" data-bs-toggle="tooltip"
                title="How often will be paying your staff? You can customize this on per job listing"></i> <sup class="text-danger">*</sup></label>
            <select class="form-control selectize" id="inputEmail4" name="payType">
                <option value="">Select how you will pay staff</option>
                @foreach($rateTypes as $rateType)
                    <option value="{{$rateType->id}}">{{$rateType->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputAddress" class="form-label">Minimum Work Hour(Weekly) <sup class="text-danger">*</sup></label>
            <input type="number" class="form-control" id="inputAddress" placeholder="Minimum Work hour" name="minWorkHour">
        </div>

        <div class="col-md-6">
            <label for="inputAddress" class="form-label">Maximum Work Hour(Weekly) <sup class="text-danger">*</sup></label>
            <input type="number" class="form-control" id="inputAddress" placeholder="Maximum Work hour" name="maxWorkHour">
        </div>

        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="localized" value="1" name="localized" checked>
                <label class="form-check-label" for="localized">
                    Localize Profile <i class="ri-information-fill" data-bs-toggle="tooltip" title="Show only Tutors from your country"></i>
                </label>
            </div>
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="activeForJob" value="1" name="activeForJob" checked>
                <label class="form-check-label" for="activeForJob">
                    Actively Employing? <i class="ri-information-fill" data-bs-toggle="tooltip" title="Are you actively employing?"></i>
                </label>
            </div>
        </div>

    </div>

    <div class="col-12 text-center mt-3">
        <button type="submit" class="default-btn submit">Complete Profile</button>
    </div>
</form>
