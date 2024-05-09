<form class="row g-3" id="processForm" method="post" action="{{route('user.stores.kyc.process')}}" enctype="multipart/form-data">
    <div class="col-md-6">
        <label for="inputState" class="form-label">Legal Business Name<sup class="text-danger">*</sup> <i class="ri-information-fill"
                                                                                                          data-bs-toggle="tooltip" title="Name of store as it appeared on the Registration Certificate"></i> </label>
        <input type="text" class="form-control" id="inputState" name="legalName" value="{{$store->name}}">
    </div>
    <div class="col-md-6">
        <label for="inputAddress" class="form-label">Registration Certificate<sup class="text-danger">*</sup></label>
        <input type="file" class="form-control" id="inputAddress"
               name="regCert">
    </div>
    <div class="col-md-6 idNumber" id="idNumber">
        <label for="inputAddress" class="form-label">Registration Number<sup class="text-danger">*</sup></label>
        <input type="text" class="form-control" id="inputAddress" placeholder="xxxx-xxxx-xxxx"
               name="regNumber">
    </div>
    <div class="col-md-6 idNumber" id="idNumber">
        <label for="inputAddress" class="form-label">Doing Business As (DBA)</label>
        <input type="text" class="form-control" id="inputAddress" placeholder="{{$store->name}}"
               name="doingBusinessAs">
    </div>
    <div class="col-12">
        <label for="inputAddress" class="form-label">Address</label>
        <textarea type="text" class="form-control" id="inputAddress"
                  placeholder="1234 Main St" name="address" >{{$store->address}}</textarea>
    </div>
    <div class="col-12">
        <label for="inputAddress" class="form-label">Proof of Address</label>
        <input type="file" class="form-control" id="inputAddress"
               name="addressProof">
    </div>
    <div class="col-md-12 text-center mt-3">
        <button class="btn btn-outline-primary rounded-pill submit" type="submit">Submit</button>
    </div>
</form>
