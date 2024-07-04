<div class="card-body">
    <form wire:submit.prevent="submit">
        <div class="row gy-3">
            <div class="col-12">
                <label class="form-label">Pin</label>
                <input type="password" wire:model.defer="newPin" class="form-control" placeholder="Enter your Pin"
                    minlength="6" maxlength="6">
                @error('newPin') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-12">
                <label class="form-label">Repeat Pin</label>
                <input type="password" wire:model.defer="newPin_confirmation" class="form-control"
                    placeholder="Repeat Pin" minlength="6" maxlength="6">
                @error('newPin_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-12">
                <label class="form-label">Account Password</label>
                <input type="password" wire:model.defer="password" class="form-control" placeholder="*******">
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary-600" wire:loading.attr="disabled">
                    <span wire:loading.remove>Submit</span>
                    <span wire:loading>Loading...</span>
                </button>
            </div>
        </div>
    </form>
</div>
