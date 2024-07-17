<div>

    @if($showInitializeStoreForm)
        @if($staff->can('create UserStore'))
            <div class="product-area">
                <div class="container-fluid">

                    <div class="submit-property-area">
                        <div class="container-fluid">
                            <form class="submit-property-form" id="processForm" wire:submit.prevent="submitInitialization">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="inputTitle" class="form-label">Store name<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control form-control-lg" id="inputTitle" wire:model.live="name">
                                        @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputCity" class="form-label">Type of Service<sup class="text-danger">*</sup></label>
                                        <select class="form-control form-control-lg" id="inputCity" wire:model.live="serviceType">
                                            <option value="">Select an option</option>
                                            @foreach($services as $service)
                                                <option value="{{$service->id}}">{{$service->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('serviceType') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Description<sup class="text-danger">*</sup></label>
                                        <textarea class="form-control form-control-lg" id="inputAddress" wire:model.live="description" rows="5"></textarea>
                                        @error('description') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputEmail4" class="form-label">Select State<sup class="text-danger">*</sup></label>
                                        <select class="form-control form-control-lg" id="inputState" wire:model.live="state">
                                            <option value="">Select a Location</option>
                                            @foreach($states as $state)
                                                <option value="{{$state->iso2}}">{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('state') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputCity" class="form-label">City<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control form-control-lg" id="inputCity" wire:model.live="city">
                                        @error('city') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Address<sup class="text-danger">*</sup></label>
                                        <textarea class="form-control form-control-lg" id="inputAddress" placeholder="1234 Main St" wire:model.live="address"></textarea>
                                        @error('address') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputCity" class="form-label">Support Phone<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control form-control-lg" id="inputCity" wire:model.live="phone">
                                        @error('phone') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputCity" class="form-label">Support Email<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control form-control-lg" id="inputCity" wire:model.live="email">
                                        @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Return Policy<i class="ri-information-fill" datat-bs-toggle="tooltip"
                                                                   title="This is a necessary protection for your product order"></i> </label>
                                            <textarea wire:model.live="returnPolicy" class="form-control summernote form-control-lg" cols="30" rows="5"></textarea>
                                        </div>
                                        @error('returnPolicy') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Refund Policy<i class="ri-information-fill" datat-bs-toggle="tooltip"
                                                                   title="This is a necessary protection for your product order"></i> </label>
                                            <textarea wire:model.live="refundPolicy" class="form-control summernote form-control-lg" cols="30" rows="5"></textarea>
                                        </div>
                                        @error('refundPolicy') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Your Store Logo</label>
                                            <div class="file-upload">
                                                <input class="form-control" type="file" accept="image/*" wire:model.live="logo">
                                            </div>
                                        </div>
                                        @error('logo') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center flex-wrap gap-28">
                                            <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                                <input class="form-check-input" type="checkbox" role="switch" id="yes" wire:model.live="verifyBusiness">
                                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="yes">
                                                    Verify Business Instantly
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-outline-success-600">
                                        <span>
                                            Initialize
                                            <div wire:loading>
                                                <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                            </div>
                                        </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        @endif
    @endif
    @if($showVerifyBusinessForm)
        @if($staff->can('create UserStoreVerification'))
                <div class="product-area">
                    <div class="container-fluid">

                        <div class="submit-property-area">
                            <div class="container-fluid">
                                <form class="row g-3" id="processForm" wire:submit.prevent="submitKYC" enctype="multipart/form-data">
                                    <div class="col-md-6">
                                        <label for="inputState" class="form-label">Legal Business Name<sup class="text-danger">*</sup>
                                            <i class="ri-information-fill"
                                               data-bs-toggle="tooltip" title="Name of store as it appeared on the Registration Certificate"></i> </label>
                                        <input type="text" class="form-control" id="inputState" name="legalName"  wire:model.live="legalName">
                                        @error('legalName') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputAddress" class="form-label">Registration Certificate<sup class="text-danger">*</sup></label>
                                        <input type="file" class="form-control" id="inputAddress"
                                               wire:model.live="regCert">
                                        @error('regCert') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 idNumber" id="idNumber">
                                        <label for="inputAddress" class="form-label">Registration Number<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control" id="inputAddress" placeholder="xxxx-xxxx-xxxx"
                                               wire:model.live="regNumber">
                                        @error('regNumber') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 idNumber" id="idNumber">
                                        <label for="inputAddress" class="form-label">Doing Business As (DBA)</label>
                                        <input type="text" class="form-control" id="inputAddress" placeholder="{{$store->name}}"
                                               wire:model.live="doingBusinessAs">
                                        @error('doingBusinessAs') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Address</label>
                                        <textarea type="text" class="form-control" id="inputAddress"
                                                  placeholder="1234 Main St" wire:model.live="address" >{{$store->address}}</textarea>
                                        @error('address') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Proof of Address</label>
                                        <input type="file" class="form-control" id="inputAddress" wire:model.live="addressProof">
                                        @error('addressProof') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-12 text-center mt-3">
                                        <button class="btn btn-outline-primary" type="submit">
                                            <span>
                                                Submit
                                                <div wire:loading>
                                                    <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                                </div>
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
        @endif
    @endif
    @if($staff->can('read UserStore'))


    @endif
</div>
