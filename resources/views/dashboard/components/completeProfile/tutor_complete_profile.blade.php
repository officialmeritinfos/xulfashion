<form id="tutorData" style="display: none;" method="post" action="{{route('complete-account-setup.process.tutor')}}"
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

        <div class="col-md-12">
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
        <div class="col-md-6">
            <label for="inputCity" class="form-label">Work Rate ({{$user->mainCurrency}}) <sup class="text-danger">*</sup></label>
            <input type="number" step="0.01" class="form-control" id="inputCity" name="workRate" value="{{$user->workRate}}">
        </div>
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Salary Type<sup class="text-danger">*</sup></label>
            <select class="form-control selectize" id="inputEmail4" name="salaryType">
                <option value="">Select how you want to be paid</option>
                @foreach($rateTypes as $rateType)
                    <option value="{{$rateType->id}}" {{($user->rateTypeId==$rateType->id)?'selected':''}}>{{$rateType->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12">
            <label for="inputEmail4" class="form-label">Type of Job<sup class="text-danger">*</sup></label>
            <select class="form-control selectize" id="inputEmail4" name="workPreference">
                <option value="">Select your job preference</option>
                <option value="1" {{($user->typeOfJob=='1')?'selected':''}}>Hybrid</option>
                <option value="2" {{($user->typeOfJob=='2')?'selected':''}}>Part-time</option>
                <option value="3" {{($user->typeOfJob=='3')?'selected':''}}>Full-time</option>
                <option value="4" {{($user->typeOfJob=='4')?'selected':''}}>Contract</option>
            </select>
        </div>

        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck" value="1" name="currentlyEmployed">
                <label class="form-check-label" for="gridCheck">
                    Currently Employed
                </label>
            </div>
        </div>
        <div class="col-md-12 row g-3" style="display: none;" id="currentlyEmployed">
            <div class="col-md-6">
                <label for="inputAddress" class="form-label">Current Employer<sup class="text-danger">*</sup></label>
                <input type="text" class="form-control" id="inputAddress" placeholder="ABC LLC" name="currentEmployer"
                value="{{$user->currentEmployer}}">
            </div>
            <div class="col-md-6">
                <label for="inputAddress" class="form-label">Country of Current Employer<sup class="text-danger">*</sup></label>
                <select class="form-control selectize" id="inputEmail4" name="employerCountry">
                    <option value="">Country of Employer</option>
                    @foreach($countries as $country)
                        <option value="{{$country->iso3}}" {{($user->currentEmployerCountry==$country->iso3)?'selected':''}}>{{$country->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="inputAddress" class="form-label">Address of Current Employer<sup class="text-danger">*</sup></label>
                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="currentEmployerAddress"
                value="{{$user->currentEmployerAddress}}">
            </div>
            <div class="col-md-6">
                <label for="inputCity" class="form-label">Current Salary ({{$user->mainCurrency}})<sup class="text-danger">*</sup> </label>
                <input type="number" step="0.01" class="form-control" id="inputCity" name="currentSalary"
                value="{{$user->currentSalary}}">
            </div>
        </div>

        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="localized" value="1" name="localized" {{($user->localized==1)?'checked':''}}>
                <label class="form-check-label" for="localized">
                    Localize Profile <i class="ri-information-fill" data-bs-toggle="tooltip" title="Make your profile only visible recruiters from your country"></i>
                </label>
            </div>
        </div>

        <div class="col-md-12">
            <label for="inputAddress" class="form-label">
                Meta Tags <i class="ri-information-fill" data-bs-toggle="tooltip" title="Be more visible by tagging your profile with popular search keywords"></i>
            </label>
            <input class="form-control selectizeAdd" id="inputEmail4" name="tutorKeywords[]" value="{{$user->tutorKeywords}}"/>
        </div>
        <div class="col-md-6">
            <label for="inputAddress" class="form-label">Minimum Work Hour(Weekly)
                <i class="ri-information-fill" data-bs-toggle="tooltip" title="How many hours minimum will you be available"></i> <sup class="text-danger">*</sup></label>
            <input type="number" class="form-control" id="inputAddress" placeholder="Minimum Work hour" name="minWorkHour"
            value="{{$user->tutorMinHour??'25'}}">
        </div>

        <div class="col-md-6">
            <label for="inputAddress" class="form-label">Maximum Work Hour(Weekly)
                <i class="ri-information-fill" data-bs-toggle="tooltip" title="How many hours maximum will you be available"></i> <sup class="text-danger">*</sup></label>
            <input type="number" class="form-control" id="inputAddress" placeholder="Maximum Work hour" name="maxWorkHour"
            value="{{$user->tutorMaxHour??'40'}}">
        </div>

        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="activeForJob" value="1" name="activeForJob" checked>
                <label class="form-check-label" for="activeForJob">
                    Actively Looking for job? <i class="ri-information-fill" data-bs-toggle="tooltip" title="Are you actively looking for job?"></i>
                </label>
            </div>
        </div>
    </div>

    <div class="col-12 text-center mt-3">
        <button type="submit" class="default-btn submit">Complete Profile</button>
    </div>
</form>
