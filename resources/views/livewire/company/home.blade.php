<div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
     Conatct : Main Section
 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="contact_main-section padding-bottom-120" id="join-waitlist">
        <div class="container">
            <div class="row row--cuatom">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">
                    <div class="contact_main-content">
                        <div class="content">
                            <div class="content-text-block">
                                <h2 class="heading-md">Fill out this form to join the wait-list</h2>
                                <p>
                                    Join over 100+ fashion designers, retailers, academy, and model who have
                                    registered on {{$siteName}} today.
                                </p>
                                <div class="content-divider"></div>
                            </div>
                        </div>
                        <div class="content_main-testimonial">
                            <div class="testimonial-widget-4" data-aos="fade-left" data-aos-delay="NaN">
                                <div class="testimonial-widget-4__rating">
                                    <img src="{{asset('home/image/icons/star-five-yellow.svg')}}" class="testimonial-widget-4__star" alt="image alt">
                                </div>
                                <p>
                                    "
                                    I am immensely proud to lead a platform that is not just about fashion commerce but
                                    about revolutionizing how fashion creators and consumers interact on a global scale.
                                    At {{$siteName}}, we are committed to empowering designers, tailors, and retailers with
                                    innovative tools that facilitate growth and success. Our mission extends beyond
                                    transactions; we strive to build a community where creativity thrives and opportunities
                                    abound. Join us as we shape the future of fashion, making it more accessible, sustainable,
                                    and rewarding for all involved.
                                    "
                                </p>
                                <div class="testimonial-widget-4__body">
                                    <div class="testimonial-widget-4__user-image">
                                        <img src="{{asset('home/image/ceo.jpeg')}}" alt="image alt" style="width: 50px;">
                                    </div>
                                    <div class="testimonial-widget-4__user-metadeta">
                                        <h4 class="testimonial-widget-4__user">Michael Erastus</h4>
                                        <span class="testimonial-widget-4__user-position">CEO & Co-founder @ {{$siteName}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="offset-xl-1 col-lg-6 col-md-10">
                    <div class="form-box-style__form-wrapper bg-light-2">
                        @if($showForm)
                            <form class="form-box-style" wire:submit.prevent="submit">
                                <div class="form-box-style__form-inner">
                                    <div class="form-box-style__form-input">
                                        <h3 class="form-box-style-title">Your name</h3>
                                        <input class="form-control bg-white" type="text" placeholder="Enter your full name"
                                               wire:model.live="name" id="name">
                                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-box-style__form-input">
                                        <h3 class="form-box-style-title">Email address</h3>
                                        <input class="form-control bg-white" type="text" placeholder="Enter your email"
                                               wire:model.live="email" >
                                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="form-box-style__form-input-button mt-4">
                                    <button type="submit" class="btn-masco rounded-pill w-100">
                                <span>
                                    Join Wait-list
                                    <div wire:loading>
                                        <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                    </div>
                                </span>
                                    </button>
                                </div>
                                <div id="captcha" class="mt-4" wire:ignore></div>

                                @error('captcha')
                                <p class="mt-3 text-sm text-red-600 text-left">
                                    <span class="text-danger"> {{ $message }}</span>
                                </p>
                                @enderror
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
                                                    <p>You have successfully joined the wait-list. We will keep you notified once we launch in September</p>
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
    </div>
</div>

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
