<div>
    <div class="row gy-4 justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Settings</h6>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="submit">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" name="#0" class="form-control" wire:model.live="name">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="#0" class="form-control" placeholder="info@gmail.com" wire:model.live="email">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Support Email </label>
                                <input type="email" class="form-control flex-grow-1" placeholder="" wire:model.live="supportEmail">
                                @error('supportEmail') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="tel" name="#0" class="form-control" wire:model.live="phone">
                                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Code Duration </label>
                                <input type="text" class="form-control flex-grow-1" wire:model.live="codeExpires">
                                @error('codeExpires') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Help Desk Link </label>
                                <input type="url" class="form-control flex-grow-1" wire:model.live="helpDesk">
                                @error('helpDesk') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">SEO Keywords </label>
                                <textarea type="text" class="form-control flex-grow-1" wire:model.live="keywords"></textarea>
                                @error('keywords') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">SEO Description </label>
                                <textarea type="text" class="form-control flex-grow-1" wire:model.live="description"></textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <button type="submit" class="btn btn-primary-600" wire:loading.attr="disabled">
                                    <span wire:loading.remove>Proceed</span>
                                    <span wire:loading>Processing...</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- card end -->

        </div>
    </div>
</div>
