<div>
    <div class="card h-100 p-0 radius-12">
        <div class="card-body p-24">
            <div class="row justify-content-center">
                <div class="col-xxl-8 col-xl-8 col-lg-8">
                    <div class="card border">
                        <div class="card-body">
                            <h6 class="text-md text-primary-light mb-16">Onboard New Merchant</h6>

                            <form wire:submit.prevent="submit" class="row">

                                <div class="mb-20">
                                    <label for="name"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Full Name <span
                                            class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8 @error('name') is-invalid @enderror"
                                        id="name" wire:model.blur="name" placeholder="Enter Full Name">
                                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-20 col-md-6">
                                    <label for="username"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Username <span
                                            class="text-danger-600">*</span></label>
                                    <input type="text"
                                        class="form-control radius-8 @error('username') is-invalid @enderror"
                                        id="username" wire:model.blur="username" placeholder="Enter username">
                                    @error('username') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-20 col-md-6">
                                    <label for="email"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Email <span
                                            class="text-danger-600">*</span></label>
                                    <input type="email"
                                        class="form-control radius-8 @error('email') is-invalid @enderror" id="email"
                                        wire:model.blur="email" placeholder="Enter email address">
                                    @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-20 col-md-6">
                                    <label for="country"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Country <span
                                            class="text-danger-600">*</span> </label>
                                    <select
                                        class="form-control radius-8 form-select @error('country') is-invalid @enderror"
                                        id="country" wire:model.blur="country">
                                        <option value="">Select an option</option>
                                        @foreach ($countries as $country)
                                        <option value="{{ $country->iso3 }}">{{ $country->name }} </option>
                                        @endforeach
                                    </select>
                                    @error('country') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-20 col-md-6">
                                    <label for="phone"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Phone</label>
                                    <input type="text"
                                        class="form-control radius-8 @error('phone') is-invalid @enderror" id="phone"
                                        wire:model.blur="phone" placeholder="Enter phone number">
                                    @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-20 col-md-12">
                                    <label for="fiat"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Account Currency
                                        <span class="text-danger-600">*</span> </label>
                                    <select
                                        class="form-control radius-8 form-select @error('fiat') is-invalid @enderror"
                                        id="fiat" wire:model.blur="fiat">
                                        <option value="">Select an option</option>
                                        @foreach ($fiats as $fiat)
                                        <option value="{{ $fiat->code }}">{{ $fiat->name }} </option>
                                        @endforeach
                                    </select>
                                    @error('fiat') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-20 col-md-6">
                                    <label for="password_confirmation"
                                           class="form-label fw-semibold text-primary-light text-sm mb-8">Password
                                        <span class="text-danger-600">*</span></label>
                                    <input type="password"
                                           class="form-control radius-8 @error('password_confirmation') is-invalid @enderror"
                                           id="password_confirmation" wire:model.blur="password_confirmation"
                                           placeholder="Enter Password">
                                    @error('password_confirmation') <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-20 col-md-6">
                                    <label for="password"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Password Confirmation<span
                                            class="text-danger-600">*</span></label>
                                    <input type="password"
                                        class="form-control radius-8 @error('password') is-invalid @enderror"
                                        id="password" wire:model.blur="password" placeholder="Repeate Password">
                                    @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <button type="submit" class="btn btn-primary-600" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Proceed</span>
                                        <span wire:loading>Processing...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('merchantCreated', (merchant) => {
                setTimeout(() => {
                    window.location.href = "{{ route('staff.users.complete-profile', ['id' => '__merchant__']) }}".replace('__merchant__', merchant);
                }, 3000);
            });
        });
    </script>
</div>
