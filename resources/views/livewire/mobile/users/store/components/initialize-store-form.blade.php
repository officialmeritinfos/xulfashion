<div>
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-header bg-dark text-white text-center">
                <h4>Create Your Store</h4>
            </div>
            <div class="card-body">
                <form id="processForm" wire:submit.prevent="processForm">
                    @include('notifications')
                    <div class="row g-4">
                        <!-- Store Name -->
                        <div class="col-md-12">
                            <label for="inputTitle" class="form-label">Store Name <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="inputTitle" wire:model.live.debounce.250="name"
                                   placeholder="e.g., Trendy Boutique" >
                            @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="inputService" class="form-label">Industry <sup class="text-danger">*</sup></label>
                            <select class="form-select selectize" id="inputService"
                                    wire:model="industry" wire:change="fetchIndustryCategories">
                                <option value="">Select an option</option>
                                <option value="fashion">Fashion</option>
                                <option value="beauty">Beauty</option>
                            </select>
                            @error('industry') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                        @if($showCategory)
                            <div class="col-md-12">
                                <label for="inputCategory" class="form-label">Category <sup class="text-danger">*</sup></label>
                                <select class="form-select selectize" id="inputCategory" wire:model="serviceType">
                                    <option value="">Select an option</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('serviceType') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        @endif


                        <!-- Description -->
                        <div class="col-12">
                            <label for="inputDescription" class="form-label">Description <sup class="text-danger">*</sup></label>
                            <textarea class="form-control editor" id="descriptionEditor" wire:model.live.debounce.250ms="description"
                                      rows="5" placeholder="Describe your store..." ></textarea>
                            @error('description') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- State -->
                        <div class="col-md-6">
                            <label for="inputState" class="form-label">Select State <sup class="text-danger">*</sup></label>
                            <select class="form-select" id="inputState" wire:model.live.debounce.250ms="state" >
                                <option value="">Select a Location</option>
                                @foreach($states as $state)
                                    <option value="{{$state->iso2}}">{{$state->name}}</option>
                                @endforeach
                            </select>
                            @error('state') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- City -->
                        <div class="col-md-6">
                            <label for="inputCity" class="form-label">City <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="inputCity" wire:model.live.debounce.250ms="city"
                                   placeholder="e.g., Atlanta" >
                            @error('city') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Address -->
                        <div class="col-12">
                            <label for="inputAddress" class="form-label">Address <sup class="text-danger">*</sup></label>
                            <textarea class="form-control" id="inputAddress" wire:model.live.debounce.250ms="address" rows="2"
                                      placeholder="1234 Main St" ></textarea>
                            @error('address') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Support Phone -->
                        <div class="col-md-6">
                            <label for="inputPhone" class="form-label">Support Phone <sup class="text-danger">*</sup></label>
                            <input type="tel" class="form-control" id="inputPhone" wire:model.live.debounce.250mx="supportPhone"
                                   placeholder="+1 800 000 0000" >
                            @error('supportPhone') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Support Email -->
                        <div class="col-md-6">
                            <label for="inputEmail" class="form-label">Support Email <sup class="text-danger">*</sup></label>
                            <input type="email" class="form-control" id="inputEmail" wire:model.live.debounce.250ms="supportEmail"
                                   placeholder="support@example.com" >
                            @error('supportEmail') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Return Policy -->
                        <div class="col-lg-12">
                            <label>Return Policy <sup class="text-danger">*</sup></label>
                            <textarea wire:model.live.debounce.250ms="returnPolicy" class="form-control summernote" id="returnPolicyEditor"
                                      rows="6" placeholder="Specify your return policy"></textarea>
                            @error('returnPolicy') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Refund Policy -->
                        <div class="col-lg-12">
                            <label>Refund Policy <sup class="text-danger">*</sup></label>
                            <textarea wire:model.live.debounce.250ms="refundPolicy" class="form-control summernote" id="refundPolicyEditor"
                                      rows="6" placeholder="Specify your refund policy"></textarea>
                            @error('refundPolicy') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Store Logo Upload -->
                        <div class="col-lg-12">
                            <label>Your Store Logo <sup class="text-danger">*</sup></label>
                            <div class="file-upload">
                                <input type="file" id="file" accept="image/*" onchange="previewImage(event)"
                                wire:model.live.debounce.250ms="file">
                                <label for="file">
                                    <i class="fa fa-file-image-o"></i> Upload Logo
                                </label>
                                <img id="imagePreview" class="image-preview" style="display: none;" wire:ignore.self/>
                            </div>
                            @error('file') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Verify Business -->
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck" wire:model.live.debounce.250ms="verifyBusiness">
                                <label class="form-check-label" for="gridCheck">
                                    Verify Business Instantly
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 text-center">
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <button type="submit" class="btn btn-outline-primary mt-0 w-50 submit mb-3 btn-auto" wire:loading.attr="disabled">
                                    <span wire:loading.remove>Create Store</span>
                                    <span wire:loading>Processing...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

