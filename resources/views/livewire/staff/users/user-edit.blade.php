<div>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card h-100 p-0 radius-12">
                <div class="card-body p-24">
                    <div class="row justify-content-center">
                        <div class="col-xxl-12 col-xl-12 col-lg-8">
                            <div class="card border">
                                <div class="card-body">
                                    <h6 class="text-md text-primary-light mb-16">Edit {{$user->name}} Information</h6>

                                    <form wire:submit.prevent="submit" class="row g-3">
                                        <div class="mb-20">
                                            <label for="name"
                                                   class="form-label fw-semibold text-primary-light text-sm mb-8">Full Name <span
                                                    class="text-danger-600">*</span></label>
                                            <input type="text" class="form-control radius-8 @error('name') is-invalid @enderror"
                                                   id="name" wire:model.live.debounce.250ms="name" placeholder="Enter Full Name">
                                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="mb-20 col-md-6">
                                            <label for="username"
                                                   class="form-label fw-semibold text-primary-light text-sm mb-8">Username <span
                                                    class="text-danger-600">*</span></label>
                                            <input type="text"
                                                   class="form-control radius-8 @error('username') is-invalid @enderror"
                                                   id="username" wire:model.live.debounce.250ms="username" placeholder="Enter username">
                                            @error('username') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="mb-20 col-md-6">
                                            <label for="email"
                                                   class="form-label fw-semibold text-primary-light text-sm mb-8">Email <span
                                                    class="text-danger-600">*</span></label>
                                            <input type="email"
                                                   class="form-control radius-8 @error('email') is-invalid @enderror" id="email"
                                                   wire:model.live.debounce.250ms="email" placeholder="Enter email address">
                                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="mb-20 col-md-4">
                                            <label for="country"
                                                   class="form-label fw-semibold text-primary-light text-sm mb-8">Country <span
                                                    class="text-danger-600">*</span> </label>
                                            <select
                                                class="form-control radius-8 form-select @error('country') is-invalid @enderror"
                                                id="country" wire:model.live.debounce.250ms="country">
                                                <option value="">Select an option</option>
                                                @foreach ($countries as $nation)
                                                    <option value="{{ $nation->iso3 }}" {{($countryCode==$nation->iso3)?'selected':''}}>{{ $nation->name }} </option>
                                                @endforeach
                                            </select>
                                            @error('country') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="mb-20 col-md-4">
                                            <label for="phone"
                                                   class="form-label fw-semibold text-primary-light text-sm mb-8">State</label>
                                            <input type="text"
                                                   class="form-control radius-8 @error('state') is-invalid @enderror" id="state"
                                                   wire:model.live.debounce.250ms="state" placeholder="Enter State">
                                            @error('state') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="mb-20 col-md-4">
                                            <label for="phone"
                                                   class="form-label fw-semibold text-primary-light text-sm mb-8">Phone</label>
                                            <input type="text"
                                                   class="form-control radius-8 @error('phone') is-invalid @enderror" id="phone"
                                                   wire:model.live.debounce.250ms="phone" placeholder="Enter phone number">
                                            @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="mb-20 col-md-12">
                                            <label for="fiat"
                                                   class="form-label fw-semibold text-primary-light text-sm mb-8">Account Currency
                                                <span class="text-danger-600">*</span> </label>
                                            <select
                                                class="form-control radius-8 form-select @error('fiat') is-invalid @enderror"
                                                id="fiat" wire:model.live.debounce.250ms="mainCurrency">
                                                <option value="">Select an option</option>
                                                @foreach ($fiats as $fiat)
                                                    <option value="{{ $fiat->code }}" {{($user->mainCurrency==$fiat->code)?'selected':''}}>{{ $fiat->name }} </option>
                                                @endforeach
                                            </select>
                                            @error('fiat') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="inputPassword4" class="form-label">Tell Us About yourself <i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                                                                     title="This is public. So make sure you properly tell your audience about yourself and what you do."></i> <sup class="text-danger">*</sup></label>
                                            <textarea type="text" class="form-control" id="inputPassword4" wire:model.live.debounce.250ms="bio"></textarea>
                                            @error('bio') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label for="inputAddress" class="form-label">
                                                Display Name <i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                title="This will serve as your name on our marketplace. This does not replace your legal name as that will be used to
                                        verify your identity"></i>
                                            </label>
                                            <input class="form-control" id="inputEmail4" wire:model.live.debounce.250ms="displayName"/>
                                            @error('displayName') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputEmail4" class="form-label">Gender<sup class="text-danger">*</sup></label>
                                            <select class="form-control" id="inputEmail4" wire:model.live.debounce.250ms="gender">
                                                <option value="">Select your gender</option>
                                                <option value="male" {{($user->gender=='male')?'selected':''}}>Male</option>
                                                <option value="female" {{($user->gender=='female')?'selected':''}}>Female</option>
                                                <option value="others" {{($user->gender=='others')?'selected':''}}>Others</option>
                                            </select>
                                            @error('gender') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputPassword4" class="form-label">Date of Birth<sup class="text-danger">*</sup></label>
                                            <input type="date" class="form-control" id="inputPassword4" wire:model.live.debounce.250ms="dob">
                                            @error('dob') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="inputAddress" class="form-label">Address <sup class="text-danger">*</sup></label>
                                            <input type="text" class="form-control" id="inputAddress" wire:model.live.debounce.250ms="address">
                                            @error('address') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center gap-3 mt-5">
                                            <button class="btn btn-outline-success" type="submit">
                                                <span>
                                                    Update
                                                    <div wire:loading>
                                                        <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                                    </div>
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- end card -->
                        </div><!-- end col-->
                    </div>
                </div><!-- end card body-->
            </div>
        </div>
    </div>

</div>
