<div>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card h-100 p-0 radius-12">
                <div class="card-body p-24">
                    <div class="row justify-content-center">
                        <div class="col-xxl-12 col-xl-12 col-lg-8">
                            <div class="card border">
                                <div class="card-body">
                                    <h6 class="text-md text-primary-light mb-16">Complete {{$user->name}} Profile</h6>

                                    <form wire:submit.prevent="submit" class="row g-3">
                                        <!-- Upload Image Start -->
                                        <div class="mb-24 mt-16">
                                            <div class="col-12">
                                                <label class="form-label">Merchant Country </label>
                                               <select class="form-control" wire:model="country">
                                                   @foreach($countries as $country)
                                                       <option value="{{$country->iso3}}" {{ ($user->countryCode==$country->iso3)?'selected':''  }}
                                                       >{{ $country->name }}</option>
                                                   @endforeach
                                               </select>
                                            </div>
                                            @error('country') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <!-- Upload Image Start -->
                                        <div class="mb-24 mt-16">
                                            <div class="col-12">
                                                <label class="form-label">Merchant Username </label>
                                                <input class="form-control" type="text" accept=".png, .jpg, .jpeg" wire:model.live="username">
                                            </div>
                                            @error('username') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <!-- Upload Image Start -->
                                        <div class="mb-24 mt-16">
                                            <div class="col-12">
                                                <label class="form-label">Merchant Image </label>
                                                <input class="form-control" type="file" accept=".png, .jpg, .jpeg" wire:model.live="photo">
                                            </div>
                                            @error('photo') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <!-- Upload Image End -->
                                        <div class="col-md-12">
                                            <label for="inputPassword4" class="form-label">Tell Us About yourself <i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                                                                     title="This is public. So make sure you properly tell your audience about yourself and what you do."></i> <sup class="text-danger">*</sup></label>
                                            <textarea type="text" class="form-control" id="inputPassword4" wire:model.blur="bio"></textarea>
                                            @error('bio') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label for="inputAddress" class="form-label">
                                                Display Name <i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                title="This will serve as your name on our marketplace. This does not replace your legal name as that will be used to
                                        verify your identity"></i>
                                            </label>
                                            <input class="form-control" id="inputEmail4" wire:model.blur="displayName"/>
                                            @error('displayName') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputEmail4" class="form-label">Gender<sup class="text-danger">*</sup></label>
                                            <select class="form-control" id="inputEmail4" wire:model.blur="gender">
                                                <option value="">Select your gender</option>
                                                <option value="male" {{($user->gender=='male')?'selected':''}}>Male</option>
                                                <option value="female" {{($user->gender=='female')?'selected':''}}>Female</option>
                                                <option value="others" {{($user->gender=='others')?'selected':''}}>Others</option>
                                            </select>
                                            @error('gender') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputEmail4" class="form-label">Merchant Type<sup class="text-danger">*</sup></label>
                                            <select class="form-control" id="inputEmail4" wire:model.blur="merchantType">
                                                <option value="">Select an Option</option>
                                                <option value="1" {{($user->merchantType=='1')?'selected':''}}>Fashion Retailer</option>
                                                <option value="2" {{($user->merchantType=='2')?'selected':''}}>Fashion Designer</option>
                                                <option value="3" {{($user->merchantType=='3')?'selected':''}}>Manufacturer</option>
                                                <option value="4" {{($user->merchantType=='4')?'selected':''}}>Model</option>
                                                <option value="5" {{($user->merchantType=='5')?'selected':''}}>Fashion School</option>
                                                <option value="6" {{($user->merchantType=='6')?'selected':''}}>Beauty Specialist</option>
                                                <option value="7" {{($user->merchantType=='7')?'selected':''}}>Cosmetics Brand</option>
                                                <option value="8" {{($user->merchantType=='8')?'selected':''}}>Beauty School</option>
                                                <option value="9" {{($user->merchantType=='9')?'selected':''}}>Event Organizer</option>
                                            </select>
                                            @error('merchantType') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputPassword4" class="form-label">Date of Birth<sup class="text-danger">*</sup></label>
                                            <input type="date" class="form-control" id="inputPassword4" wire:model.blur="dob">
                                            @error('dob') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="inputAddress" class="form-label">Address <sup class="text-danger">*</sup></label>
                                            <input type="text" class="form-control" id="inputAddress" wire:model.blur="address">
                                            @error('address') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="inputAddress" class="form-label">Keywords <sup class="text-danger">*</sup></label>
                                            <input type="text" class="form-control" id="inputAddress" wire:model.blur="tutorKeywords" value="{{$user->tutorKeywords}}">
                                            @error('tutorKeywords') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-switch switch-success d-flex align-items-center gap-3">
                                                <input class="form-check-input" type="checkbox" role="switch" id="submitKyc" wire:model.live="submitKyc" value="1">
                                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="submitKyc">
                                                    Submit KYC <i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                  title="If you have the Merchant's KYC Documents, you can upload them in the next page."></i>
                                                </label>
                                            </div>
                                            @error('submitKyc') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center gap-3 mt-5">
                                            <button class="btn btn-outline-success" type="submit">
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
                            </div><!-- end card -->
                        </div><!-- end col-->
                    </div>
                </div><!-- end card body-->
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('merchantProfileCompleted', (url) => {
                setTimeout(() => {
                    window.location.href = url
                }, 3000);
            });
        });
    </script>

</div>
