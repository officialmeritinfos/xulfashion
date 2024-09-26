<section class="contact_area section_top card mt-3">
    <div class="container card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="contact_form">
                    @if($showForm)
                        <form  class="row" wire:submit.prevent="submit">

                            <div class="col-lg-12 mb-4">
                                <label for="Email" class="form-label">Email Address*</label>
                                <input type="email" class="form-control" id="Email" wire:model.live="email">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-12 mb-4">
                                <label for="message" class="form-label">Why are you deleting your account?*</label>
                                <textarea class="form-control" name="reason" id="message" wire:model.live="reason"></textarea>

                                @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-12 text-center">
                                <div id="captcha" class="mt-4" wire:ignore></div>

                                @error('captcha')
                                <p class="mt-3 text-sm text-red-600 text-center">
                                    <span class="text-danger"> {{ $message }}</span>
                                </p>
                                @enderror
                            </div>
                            <div class="col-lg-12 text-center">
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <span>
                                        Delete Now
                                        <i class="ti-arrow-right" wire:loading.remove></i>
                                        <div wire:loading>
                                            <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                        </div>
                                    </span>
                                </button>
                            </div>
                            <p>
                                Your account deletion request will be processed in accordance to our privacy policy .
                            </p>
                        </form>
                    @endif

                    @if($showSuccessForm)
                        <section class="error-section bg-light-2">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-xxl-12 col-lg-12 col-sm-12 col-xs-12 col-12">
                                        <div class="error-content">
                                            <div class="error-content__image">
                                                <img src="{{asset('home/image/confirmed.svg')}}" alt="image alt">
                                            </div>
                                            <h2 class="heading-md text-black">Successful</h2>
                                            <p>Please verify your request from your registered email.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>


<script src="https://www.google.com/recaptcha/api.js?onload=handle&render=explicit"
        async
        defer>
</script>

<script>
    var  handle = function(e) {
        widget = grecaptcha.render('captcha', {
            'sitekey': '{{ config('app.recaptcha_key') }}',
            'theme': 'light', // you could switch between dark and light mode.
            'callback': verify
        });

    }
    var verify = function (response) {
        @this.set('captcha', response)
    }
</script>
