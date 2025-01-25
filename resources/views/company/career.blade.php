@extends('company.layout.base')
@section('content')

    <!--
=============================================
Block Feature Thirty for Xulfashion Careers
=============================================
-->
    <div class="block-feature-thirty bg-one border-30 z-1 pt-120 lg-pt-80 pb-130 lg-pb-80 mt-30 lg-mt-20 position-relative">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-7 col-lg-6 order-lg-last">
                    <div class="ps-xl-5">
                        <div class="title-one">
                            <h2>Join Us & Shape the Future of Fashion & Beauty</h2>
                        </div>
                        <p class="fs-28 fw-500 text-dark mt-55 lg-mt-30 mb-70 lg-mb-40 pe-xxl-5">
                            "At Xulfashion, we’re creating solutions that empower fashion and beauty businesses globally. Join our team and contribute to a meaningful and innovative journey."
                        </p>
                        <div class="fs-24 text-dark mb-40 lg-mb-30">- Chijioke Emmanuel, CAO, Xulfashion</div>
                        <a href="https://xultechng.com/company/career" target="_blank" class="btn-one">Explore Careers</a>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6">
                    <img src="{{asset('home/mobile/team/chijiokeemmanuel.jpeg')}}" alt="Xulfashion Careers" class="media-img md-mt-40">
                </div>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_83.svg')}}" alt="Career Shape" class="shapes shape_01">
    </div>
    <!-- /.block-feature-thirty -->


    <!--
=============================================
Block Feature Two for Xulfashion Perks
=============================================
-->
    <div class="block-feature-two mb-30 lg-mb-20">
        <div class="row gx-xl-4">
            <div class="col-lg-4 d-flex wow fadeInUp mt-30 lg-mt-20">
                <div class="card-style-one text-center border-30 bg-three w-100">
                    <div class="icon rounded-circle d-flex align-items-center justify-content-center m-auto">
                        <img src="{{asset('home/mobile/images/icon/growth.webp')}}" alt="Growth Icon">
                    </div>
                    <h3>Professional Growth</h3>
                    <p class="fs-24 fw-500 text-dark">Enhance your skills and build a rewarding career with continuous learning and mentorship opportunities.</p>
                </div>
            </div>
            <div class="col-lg-4 d-flex wow fadeInUp mt-30 lg-mt-20" data-wow-delay="0.1s">
                <div class="card-style-one text-center border-30 bg-three w-100">
                    <div class="icon rounded-circle d-flex align-items-center justify-content-center m-auto">
                        <img src="{{asset('home/mobile/images/icon/teamwork.svg')}}" alt="Teamwork Icon">
                    </div>
                    <h3>Collaborative Environment</h3>
                    <p class="fs-24 fw-500 text-dark">Work with a passionate and innovative team that values collaboration and shared success.</p>
                </div>
            </div>
            <div class="col-lg-4 d-flex wow fadeInUp mt-30 lg-mt-20" data-wow-delay="0.2s">
                <div class="card-style-one text-center border-30 bg-three w-100">
                    <div class="icon rounded-circle d-flex align-items-center justify-content-center m-auto">
                        <img src="{{asset('home/mobile/images/icon/benefits.png')}}" alt="Benefits Icon">
                    </div>
                    <h3>Comprehensive Benefits</h3>
                    <p class="fs-24 fw-500 text-dark">Enjoy competitive salaries, healthcare plans, and other exciting perks as part of our team.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-two -->


    <!--
=============================================
Block Feature Thirty One for Xulfashion Careers
=============================================
-->
    <div class="block-feature-thirtyOne bg-one border-30 z-1 pt-120 lg-pt-80 pb-130 lg-pb-80 mb-30 lg-mb-20 position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="title-one">
                        <h2>Why Work at Xulfashion?</h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="accordion accordion-style-five ms-xxl-5 md-mt-50" id="accordionThree">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button pt-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Empowerment
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionThree">
                                <div class="accordion-body">
                                    <p class="fs-22">Join a team that values your ideas and empowers you to take initiatives that drive impact.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Purpose
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionThree">
                                <div class="accordion-body">
                                    <p class="fs-22">Contribute to a platform that’s transforming the fashion and beauty industry for the better.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    Growth
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionThree">
                                <div class="accordion-body">
                                    <p class="fs-22">Grow with us through mentorship programs, training opportunities, and leadership paths.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="video-banner d-flex align-items-center justify-content-center mt-100 lg-mt-60">
                <a class="video-btn tran3s rounded-circle d-flex align-items-center justify-content-center" data-fancybox=""
                   href="{{ config('app.about-xulfashion-video') }}">
                    <i class="fa-sharp fa-solid fa-play"></i>
                </a>
            </div>

            <div class="counter-wrapper mt-70 lg-mt-40">
                <div class="row justify-content-between">
                    <div class="col-xl-4 col-lg-4">
                        <div class="counter-block-one text-center text-lg-start mt-20">
                            <div class="main-count fw-500 color-dark"><span class="counter">500+</span></div>
                            <span class="fs-22">Employees Globally</span>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4">
                        <div class="counter-block-one text-center mt-20">
                            <div class="main-count fw-500 color-dark"><span class="counter">30</span>+</div>
                            <span class="fs-22">Countries Represented</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 ms-auto">
                        <div class="counter-block-one text-center text-lg-start mt-20">
                            <div class="main-count fw-500 color-dark"><span class="counter">100%</span></div>
                            <span class="fs-22">Remote Friendly</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-thirtyOne -->




@endsection
