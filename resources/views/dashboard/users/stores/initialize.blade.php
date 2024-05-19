@extends('dashboard.layout.base')
@section('content')

    <div class="submit-property-area">
        <div class="container-fluid">
            <form class="submit-property-form" id="processForm" action="{{route('user.stores.initialize.process')}}" method="post">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="inputTitle" class="form-label">Store name<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="inputTitle" name="name">
                    </div>
                    <div class="col-md-6">
                        <label for="inputCity" class="form-label">Type of Service<sup class="text-danger">*</sup></label>
                        <select class="form-control form-control-lg selectize" id="inputCity" name="serviceType">
                            <option value="">Select an option</option>
                            @foreach($services as $service)
                                <option value="{{$service->id}}">{{$service->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Description<sup class="text-danger">*</sup></label>
                        <textarea class="form-control" id="inputAddress" name="description" rows="5"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Select State<sup class="text-danger">*</sup></label>
                        <select class="form-control form-control-lg selectize" id="inputState" name="state">
                            <option value="">Select a Location</option>
                            @foreach($states as $state)
                                <option value="{{$state->iso2}}">{{$state->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputCity" class="form-label">City<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="inputCity" name="city">
                    </div>
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Address<sup class="text-danger">*</sup></label>
                        <textarea class="form-control" id="inputAddress" placeholder="1234 Main St" name="address"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="inputCity" class="form-label">Support Phone<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="inputCity" name="phone">
                    </div>
                    <div class="col-md-6">
                        <label for="inputCity" class="form-label">Support Email<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="inputCity" name="email">
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Return Policy<i class="ri-information-fill" datat-bs-toggle="tooltip"
                                                   title="This is a necessary protection for your product order"></i> </label>
                            <textarea name="returnPolicy" class="form-control summernote" cols="30" rows="5"></textarea>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Refund Policy<i class="ri-information-fill" datat-bs-toggle="tooltip"
                                                   title="This is a necessary protection for your product order"></i> </label>
                            <textarea name="refundPolicy" class="form-control summernote" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Your Store Logo</label>
                            <div class="file-upload">
                                <input type="file" name="file" id="file" class="inputfile" accept="image/*">
                                <label class="upload" for="file">
                                    <i class="ri-image-2-fill"></i>
                                    Upload Photo
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck" name="verifyBusiness">
                            <label class="form-check-label" for="gridCheck">
                                Verify Business Instantly
                            </label>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="default-btn submit">Initialize</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script src="{{asset('requests/dashboard/user/stores.js')}}"></script>
    @endpush
@endsection
