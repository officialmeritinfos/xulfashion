<section class="contact_area section_top" data-bg-color="#F5F9FF">
    <ul class="list-unstyled features_bg_shap">
        <li data-parallax='{"x": 30, "y": 50}'><img src="{{asset('home/main/img/home-one/testimonial-dot.png')}}" alt=""></li>
        <li data-parallax='{"x": 0, "y": 100}'><img src="{{asset('home/main/img/blog/dot.png')}}" alt=""></li>
    </ul>
    <div class="container">
        <div class="section_title text-center">
            <h2>No longer want to be on {{$siteName}}? <br> No problem, fill this form to delete your account. </h2>
        </div>
        <div class="row">
            <div class="col-lg-8">
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
                            <div id="captcha" class="mt-4" wire:ignore></div>

                            @error('captcha')
                            <p class="mt-3 text-sm text-red-600 text-left">
                                <span class="text-danger"> {{ $message }}</span>
                            </p>
                            @enderror
                            <div class="col-lg-12 mt-3">
                                <button type="submit" class="btn theme_btn_two hover_effect">Delete Now<i
                                        class="ti-arrow-right"></i></button>
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
            <div class="col-lg-4">
                <div class="get_info_item text-center">
                    <div class="icon">
                        <img src="{{asset('home/main/img/contact/mail.svg')}}" alt="">
                    </div>
                    <h4 class="get_title">New help?</h4>
                    <ul class="list-unstyled get_info">
                        <li><a href="{{$web->email}}">
                                {{$web->email}}
                            </a></li>
                    </ul>
                </div>
                <div class="get_info_item text-center">
                    <div class="icon yellow">
                        <img src="{{asset('home/main/img/ticket.svg')}}" style="width: 100px;" alt="">
                    </div>
                    <h4 class="get_title">Open Ticket</h4>
                    <ul class="list-unstyled get_info">
                        <li>Ticket:<a href="{{$web->ticketHelpDesk}}">Open Ticket</a></li>
                    </ul>
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
