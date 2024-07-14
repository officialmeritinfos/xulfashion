<div>
    <div class="row gy-4 justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Add new ads to {{$user->name}} account</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="submit" class="row gy-3">
                        <div class="col-md-6">
                            <label class="form-label">State<i class="text-danger">*</i> </label>
                            <select type="text" wire:model.live="location" class="form-control form-control-lg">
                                <option value="">Select Location</option>
                                @foreach($states as $state)
                                    <option value="{{$state->iso2}}">{{$state->name}}</option>
                                @endforeach
                            </select>
                            @error('location') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Featured Image<i class="text-danger">*</i></label>
                            <input type="file" wire:model.live="featuredImage" class="form-control form-control-lg">
                            @error('featuredImage') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Title<i class="text-danger">*</i></label>
                            <input type="text" wire:model.live="title" class="form-control form-control-lg" placeholder="Enter Ad title">
                            @error('title') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Company Name</label>
                            <input type="text" wire:model.live="companyName" class="form-control form-control-lg" placeholder="ABC INC.">
                            @error('companyName') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Service Type<i class="text-danger">*</i> </label>
                            <select type="text" wire:model.live="serviceType" class="form-control form-control-lg">
                                <option value="">Select Service Type</option>
                                @foreach($services as $service)
                                    <option value="{{$service->id}}">{{$service->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Description<i class="text-danger">*</i> </label>
                            <textarea wire:model.live="description" class="form-control form-control-lg" rows="8"></textarea>
                            @error('description') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12 row mt-3">
                            <label for="inputPrice" class="form-label">Price<sup class="text-danger">*</sup></label>
                            <div class="col-12">
                                <div class="d-flex align-items-center flex-wrap gap-28">
                                    <div class="form-check checked-primary d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="radio" id="horizontal1"
                                               wire:model.live="priceType" wire:click="togglePriceType(1)" value="1">
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="horizontal1"> Contact for price </label>
                                    </div>
                                    <div class="form-check checked-secondary d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="radio" id="horizontal2"
                                               wire:model.live="priceType" wire:click="togglePriceType(2)" value="2">
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                               for="horizontal2"> Specify Price </label>
                                    </div>
                                </div>
                                @error('priceType') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12 price mt-3" @if($priceType != 2) style="display: none;" @endif>
                                <input type="text" class="form-control form-control-lg" id="price" placeholder="Price"  wire:model.live="price"/>
                                @error('price') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-12 mt-3 negotiate">
                            <label for="inputPrice" class="form-label">Are you open to negotiation?</label>
                            <div class="d-flex align-items-center flex-wrap gap-28">
                                <div class="form-check checked-primary d-flex align-items-center gap-2">
                                    <input class="form-check-input" type="radio" name="horizontal" id="horizontal1" value="1" wire:model.live="negotiate">
                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="horizontal1"> Yes </label>
                                </div>
                                <div class="form-check checked-secondary d-flex align-items-center gap-2">
                                    <input class="form-check-input" type="radio" name="horizontal" id="horizontal2" value="2" wire:model.live="negotiate">
                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="horizontal2"> No </label>
                                </div>
                                <div class="form-check checked-success d-flex align-items-center gap-2">
                                    <input class="form-check-input" type="radio" name="horizontal" id="horizontal3" value="3" wire:model.live="negotiate">
                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="horizontal3"> Not Sure </label>
                                </div>
                            </div>
                            @error('negotiate') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="inputAddress" class="form-label">Merchant Contact Number</label>
                            <input type="text" class="form-control form-control-lg" id="inputAddress" value="{{$user->phone}}" readonly>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="inputAddress" class="form-label">Merchant Name</label>
                            <input type="text" class="form-control form-control-lg" id="inputAddress" value="{{$user->name}}" readonly>
                        </div>
                        <div class="col-12 mt-3">
                            <label for="inputAddress" class="form-label">Category</label>
                            <input type="text" class="form-control form-control-lg selectizeAdd" id="inputAddress" wire:model.live="category">
                            @error('category.*') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-12 mt-3">
                            <label class="form-label">Photos</label>
                            <input type="file" wire:model="photos" class="form-control form-control-lg" multiple />
                            @error('photos.*') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12 text-center mt-3">
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
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('adsCreated', (url) => {
                setTimeout(() => {
                    window.location.href = url
                }, 3000);
            });
        });
    </script>
</div>
