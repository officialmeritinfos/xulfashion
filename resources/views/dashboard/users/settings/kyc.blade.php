<form class="row g-3" id="individualKyc" method="post" action="{{route('user.settings.kyc.update')}}" enctype="multipart/form-data">
    <div class="row g-3" id="directorId">
        <div class="col-md-12">
            <label for="inputState" class="form-label">Mode of Verification</label>
            <select id="inputState" class="form-select form-control" name="docType">
                <option selected value="">Choose...</option>
                @foreach($userDocs as $doc)
                    <option  value="{{$doc->slug}}" data-title="{{$doc->name}}"
                             data-back="{{$doc->hasBack}}">{{$doc->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="row g-3 idUploads" style="display: none;" id="idUploads">
            <div class="col-md-6 idNumber" id="idNumber">
                <label for="inputAddress" class="form-label"><span class="idName"></span> Number</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="xxxx-xxxx-xxxx"
                       name="idNumber">
            </div>
            <div class="col-md-6 frontImage" id="frontImage">
                <label for="inputAddress" class="form-label">Front of <span class="idName"></span> </label>
                <input type="file" class="form-control" id="inputAddress" name="frontImage">
            </div>
            <div class="col-md-4 backImage"  id="backImage" style="display: none;">
                <label for="inputAddress" class="form-label">Back of <span class="idName"></span> </label>
                <input type="file" class="form-control" id="inputAddress" name="backImage">
            </div>
        </div>
        <div class="col-md-6">
            <label for="inputUsername" class="form-label">
                Country
                <i class="ri-question-line" data-bs-toggle="tooltip" data-placement="top"
                   title="We need to know where you are from for AML purposes"></i>
            </label>
            <select class="form-control country" id="inputPassword4" name="country">
                <option value="">Select an Option</option>
                @foreach($countries as $country)
                    @if($country->iso3 ==$user->countryCode)
                        <option value="{{$country->iso3}}" selected>{{$country->name}}</option>
                    @endif
                    <option value="{{$country->iso3}}">{{$country->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputState" class="form-label">State</label>
            <input type="text" class="form-control" id="inputState" name="state" value="{{$user->state}}">
        </div>
        <div class="col-12">
            <label for="inputAddress" class="form-label">Address</label>
            <textarea type="text" class="form-control" id="inputAddress"
                      placeholder="1234 Main St" name="address" >{{$user->address}}</textarea>
        </div>
        <div class="col-12">
            <label for="inputAddress" class="form-label">Proof of Address</label>
            <input type="file" class="form-control" id="inputAddress"
                   name="addressProof">
        </div>
    </div>
    <div class="col-md-12 text-center mt-3">
        <button class="btn btn-outline-primary rounded-pill submit" type="submit" id="submitIndividualKyc">Submit</button>
    </div>
</form>
