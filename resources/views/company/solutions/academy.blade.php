@extends('company.layout.base')
@section('content')

    <!--
	=============================================
		Hero Banner
	==============================================
-->
    <div class="hero-banner-seven z-1 position-relative pt-180 lg-pt-140 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="hero-heading text-center d-flex align-items-center justify-content-center flex-wrap wow fadeInUp">
                        <img src="{{asset('home/mobile/images/shape/shape_60.svg')}}" alt="" class="shape shape_01 me-xl-5 me-4">
                        <span>EDUCATE</span>
                        <img src="{{asset('home/mobile/images/shape/shape_61.svg')}}" alt="" class="shape shape_02 ms-xl-5 ms-4">

                        <span class="position-relative w-100">
						<img src="{{asset('home/mobile/images/shape/shape_64.png')}}" alt="" class="shapes shape_05">
						INSPIRE<span class="fst-italic">LEARN.</span>
						<img src="{{asset('home/mobile/images/icon/smile.svg')}}" alt="" class="shapes smile_icon">
						<img src="{{asset('home/mobile/images/shape/shape_65.png')}}" alt="" class="shapes shape_06">
					</span>

                        <img src="{{asset('home/mobile/images/shape/shape_62.svg')}}" alt="" class="shape shape_03 me-xl-5 me-4">
                        <span>CREATE</span>
                        <img src="{{asset('home/mobile/images/shape/shape_63.svg')}}" alt="" class="shape shape_04 ms-xl-5 ms-4">
                    </h1>
                    <p class="pt-35 font-Playfair sub-heading wow fadeInUp" data-wow-delay="0.1s">
                        <span class="fw-bold">Empowering Fashion and Beauty Schools</span> to streamline admissions, sell courses, and inspire creativity.
                    </p>

                    <div class="d-sm-flex justify-content-between align-items-center">
                        <div class="mt-20 xs-mt-40">
                            <img src="{{asset('home/mobile/images/assets/avatar_2.png')}}" alt="" class="m-auto">
                            <div class="rating text-center text-sm-start xs-pt-10 xs-pb-20">
                                <div class="fs-24"><span class="fw-500 text-dark">Trusted by thousands</span> (4.7 Rating)</div>
                            </div>
                        </div>
                        <img src="{{asset('home/mobile/images/shape/shape_67.svg')}}" alt="" class="wave-shape d-none d-lg-block">
                        <div class="mt-20 text-center text-sm-start">
                            <div class="position-relative d-inline-block quote-bg">
                                <img src="{{asset('home/mobile/images/shape/shape_66.svg')}}" alt="">
                                <a href="{{ route('home.download') }}" class="quote-text fw-500">Get Started Today</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.hero-banner-seven -->

    <!--
	=====================================================
		Block Feature Nineteen
	=====================================================
-->
    <div class="block-feature-nineteen mt-130 lg-mt-80">
        <div class="container xl">
            <div class="position-relative">
                <div class="title-three">
                    <h2>Academy Solutions</h2>
                </div>

                <div class="service-slider-one pt-50 lg-pt-30">
                    <div class="item">
                        <div class="card-style-nine" style="background: #FFE073;">
                            <div class="num fw-500">01.</div>
                            <div class="title text-uppercase">ADMISSIONS</div>
                            <a href="{{ route('home.download') }}" class="service-heading text-uppercase fw-500">Organize & Manage Admissions</a>
                            <img src="{{asset('home/mobile/images/shape/shape_68.png')}}" alt="" class="shapes illustration">
                        </div>
                        <!-- /.card-style-nine -->
                    </div>
                    <div class="item">
                        <div class="card-style-nine" style="background: #FF9AE3;">
                            <div class="num fw-500">02.</div>
                            <div class="title text-uppercase">COURSE MANAGEMENT</div>
                            <a href="{{ route('home.download') }}" class="service-heading text-uppercase fw-500">Sell and Customize Courses</a>
                            <img src="{{asset('home/mobile/images/shape/shape_69.png')}}" alt="" class="shapes illustration">
                        </div>
                        <!-- /.card-style-nine -->
                    </div>
                    <div class="item">
                        <div class="card-style-nine" style="background: #45F08D;">
                            <div class="num fw-500">03.</div>
                            <div class="title text-uppercase">FEE STRUCTURE</div>
                            <a href="{{ route('home.download') }}" class="service-heading text-uppercase fw-500">Tailored Forms & Fee Management</a>
                            <img src="{{asset('home/mobile/images/shape/shape_70.png')}}" alt="" class="shapes illustration">
                        </div>
                        <!-- /.card-style-nine -->
                    </div>
                    <div class="item">
                        <div class="card-style-nine" style="background: #A394FF;">
                            <div class="num fw-500">04.</div>
                            <div class="title text-uppercase">ONLINE TOOLS</div>
                            <a href="{{ route('home.download') }}" class="service-heading text-uppercase fw-500">Efficient Enrollment Tools</a>
                            <img src="{{asset('home/mobile/images/shape/shape_71.png')}}" alt="" class="shapes illustration">
                        </div>
                        <!-- /.card-style-nine -->
                    </div>
                    <div class="item">
                        <div class="card-style-nine" style="background: #94E5FF;">
                            <div class="num fw-500">05.</div>
                            <div class="title text-uppercase">ANALYTICS</div>
                            <a href="{{ route('home.download') }}" class="service-heading text-uppercase fw-500">Track Performance & Growth</a>
                            <img src="{{asset('home/mobile/images/shape/shape_69.png')}}" alt="" class="shapes illustration">
                        </div>
                        <!-- /.card-style-nine -->
                    </div>
                </div>

                <ul class="slider-arrows slick-arrow-one d-flex justify-content-center style-none">
                    <li class="prev_a slick-arrow"><i class="fa-solid fa-arrow-left-long"></i></li>
                    <li class="next_a slick-arrow"><i class="fa-solid fa-arrow-right-long"></i></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /.block-feature-nineteen -->

    <!--
	=====================================================
		Block Feature Twenty
	=====================================================
-->
    <div class="block-feature-twenty mt-180 lg-mt-80">
        <div class="container xl">
            <div class="row gx-xxl-5 align-items-center">
                <div class="col-lg-7">
                    <h2>Empower Your Academy with Xulfashion</h2>
                    <div class="mt-55 lg-mt-30 mb-45 lg-mb-30">
                        <div class="row">
                            <div class="col-xxl-9 col-xl-10">
                                <p class="fs-28 mb-35">Seamlessly manage admissions, courses, and fee structures for your fashion or beauty school.</p>
                                <p class="fs-28">Streamline operations, enhance student experiences, and grow your institution with Xulfashion's powerful tools.</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="me-5"><a href="about-us-v1" class="btn-five tran3s">Let’s Get Started</a></div>
                        <img src="{{asset('home/mobile/images/shape/shape_72.svg')}}" alt="" class="d-none d-sm-block">
                    </div>
                </div>
                <div class="col-lg-5 text-center text-lg-end">
                    <div class="img-box d-inline-block position-relative z-1">
                        <img src="{{asset('home/mobile/images/media/img_15.jpg')}}" alt="" class="main-img">
                        <div class="text-sticker">
                            <img src="{{asset('home/mobile/images/shape/shape_73.svg')}}" alt="">
                            <div>1 Year of excellence</div>
                        </div>
                        <img src="{{asset('home/mobile/images/shape/shape_74.png')}}" alt="" class="shapes shape_01">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-twenty -->

    <!--
	=====================================================
		Counter Section One
	=====================================================
-->
    <div class="counter-section-one border-top border-bottom border-dark border-2 mt-130 lg-mt-80 sm-pt-20 sm-pb-20">
        <div class="container xl">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-4 text-center text-lg-start">
                    <div class="counter-block d-inline-block">
                        <div class="main-count font-Montserrat"><span class="counter">2.5</span>k+</div>
                        <p class="text-center fs-22 text-dark">Admission Forms Sold</p>
                    </div>
                    <!-- /.counter-block -->
                </div>
                <div class="col-lg-6 col-md-4">
                    <div class="counter-block position-relative z-1 skew-line text-center pt-70 lg-pt-30 pb-70 lg-pb-30">
                        <div class="main-count font-Montserrat"><span class="counter">10</span>k+</div>
                        <p class="text-center fs-22">Students Enrolled</p>
                    </div>
                    <!-- /.counter-block -->
                </div>
                <div class="col-lg-3 text-center text-lg-end col-md-4">
                    <div class="counter-block d-inline-block">
                        <div class="main-count font-Montserrat"><span class="counter">500</span></div>
                        <p class="text-center fs-22 text-dark">Academies Partnered</p>
                    </div>
                    <!-- /.counter-block -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.counter-section-one -->


    <!--
	=====================================================
		Project Section One
	=====================================================
-->
    <div class="project-section-one mt-180 lg-mt-80">
        <div class="container xl">
            <div class="position-relative">
                <div class="title-three pb-10">
                    <h2>Academy Highlights</h2>
                </div>

                <div class="project-block-one overflow-hidden mt-60 lg-mt-20">
                    <div class="row gx-0">
                        <div class="col-lg-6 d-flex">
                            <div class="text-meta w-100">
                                <div class="num font-Montserrat">01.</div>
                                <a href="{{ route('home.download') }}" class="title text-uppercase fw-500">Tailored Admission Process</a>
                                <p class="fs-28 text-dark">Simplify admissions with customizable forms and structured processes to onboard students seamlessly.</p>
                                <a href="{{ route('home.download') }}" class="arow-icon"><i class="fa-light fa-arrow-up-right"></i></a>

                            </div>
                            <!-- /.text-meta -->
                        </div>
                        <div class="col-lg-6 d-flex">
                            <div class="image-meta w-100" style="background: #45F08D;">
                                <img src="{{asset('home/mobile/images/admission_process.png')}}" alt="Admission Process Illustration" class="ms-auto wow fadeInRight">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.project-block-one -->

                <div class="project-block-one overflow-hidden mt-60 sm-mt-40">
                    <div class="row gx-0">
                        <div class="col-lg-6 d-flex">
                            <div class="text-meta w-100">
                                <div class="num font-Montserrat">02.</div>
                                <a href="{{ route('home.download') }}" class="title text-uppercase fw-500">Customized Course Sales</a>
                                <p class="fs-28 text-dark">Empower academies to sell tailored courses with adjustable fees, schedules, and structures.</p>
                                <a href="{{ route('home.download') }}" class="arow-icon"><i class="fa-light fa-arrow-up-right"></i></a>

                            </div>
                            <!-- /.text-meta -->
                        </div>
                        <div class="col-lg-6 d-flex">
                            <div class="image-meta d-flex align-items-end justify-content-end w-100" style="background: #FFE073;">
                                <img src="{{asset('home/mobile/images/sell-courses.png')}}" alt="Course Sales Illustration" class="wow fadeInUp">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.project-block-one -->

                <div class="project-block-one overflow-hidden mt-60 sm-mt-40">
                    <div class="row gx-0">
                        <div class="col-lg-6 d-flex">
                            <div class="text-meta w-100">
                                <div class="num font-Montserrat">03.</div>
                                <a href="{{ route('home.download') }}" class="title text-uppercase fw-500">Advanced Analytics</a>
                                <p class="fs-28 text-dark">Leverage detailed analytics to monitor student engagement, course performance, and enrollment trends.</p>
                                <a href="{{ route('home.download') }}" class="arow-icon"><i class="fa-light fa-arrow-up-right"></i></a>

                            </div>
                            <!-- /.text-meta -->
                        </div>
                        <div class="col-lg-6 d-flex">
                            <div class="image-meta d-flex align-items-end justify-content-center w-100" style="background: #FF92DF;">
                                <img src="{{asset('home/mobile/images/course-analytics.png')}}" alt="Analytics Dashboard Illustration" class="wow fadeInUp">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.project-block-one -->
            </div>
        </div>
    </div>


    <!--
    =====================================================
        FAQ Section Three
    =====================================================
    -->
    <div class="faq-section-three position-relative mt-150 lg-mt-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="title-four">
                        <div class="text-uppercase mb-10">FAQ</div>
                        <h2 class="fw-bold">Questions & Answers</h2>
                    </div>
                    <p class="fs-22 text-dark pe-xxl-5 mt-40 md-mt-10 mb-40">Find your answers here. If you don’t find it, please contact us.</p>
                    <a href="{{ route('home.contact') }}" class="btn-eleven">Contact us</a>
                </div>
                <div class="col-lg-7">
                    <div class="accordion accordion-style-two p0 shadow-none ms-xl-4 md-mt-40" id="accordionFour">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneA" aria-expanded="false" aria-controls="collapseOneA">
                                    What is {{$siteName}}'s Academy Solution?
                                </button>
                            </h2>
                            <div id="collapseOneA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">{{$siteName}}'s Academy Solution helps fashion and beauty schools manage their admissions, sell customized courses, and streamline the learning experience for students.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoA" aria-expanded="false" aria-controls="collapseTwoA">
                                    How can I use {{$siteName}} for admissions?
                                </button>
                            </h2>
                            <div id="collapseTwoA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">You can create and customize admission forms, set application fees, and monitor submissions directly on {{$siteName}}. This ensures a smooth and efficient process.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeA" aria-expanded="true" aria-controls="collapseThreeA">
                                    Can I sell courses on {{$siteName}}?
                                </button>
                            </h2>
                            <div id="collapseThreeA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes! You can list and sell courses directly on {{$siteName}}. Customize course details such as pricing, schedule, and curriculum to suit your institution’s needs.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourA" aria-expanded="true" aria-controls="collapseFourA">
                                    How secure is the payment system for courses and forms?
                                </button>
                            </h2>
                            <div id="collapseFourA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Payments on {{$siteName}} are processed securely through integrated payment gateways. Schools can also withdraw their earnings without restrictions.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiveA" aria-expanded="true" aria-controls="collapseFiveA">
                                    Can I track student applications and course enrollments?
                                </button>
                            </h2>
                            <div id="collapseFiveA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Absolutely. {{$siteName}} provides tools to monitor applications, track enrollments, and generate analytics for better management of your academy.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSixA" aria-expanded="true" aria-controls="collapseSixA">
                                    Can I offer free courses or promotional discounts?
                                </button>
                            </h2>
                            <div id="collapseSixA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, you can offer free courses or provide promotional discounts to attract more students and grow your academy’s reach.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSevenA" aria-expanded="true" aria-controls="collapseSevenA">
                                    Does {{$siteName}} support multiple instructors?
                                </button>
                            </h2>
                            <div id="collapseSevenA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, you can add multiple instructors, assign them to courses, and manage their access through an easy-to-use dashboard.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.faq-section-three -->


    <!--
=====================================================
    Fancy Banner Eight
=====================================================
-->
    <div class="fancy-banner-eight position-relative z-1 mt-200 xl-mt-150 lg-mt-100 mb-120 lg-mb-80">
        <div class="container xl">
            <div class="row">
                <div class="col-xl-10 col-lg-10 m-auto text-center">
                    <h2 class="hero-heading font-Montserrat d-flex align-items-center justify-content-center flex-wrap">
                        <span>READY TO &nbsp;</span>
                        <span class="position-relative">
                        EMPOWER
                        <img src="{{asset('home/mobile/images/icon/smile.svg')}}" alt="" class="shapes smile_icon">
                        <img src="{{asset('home/mobile/images/shape/shape_78.png')}}" alt="" class="shapes shape_01">
                    </span>
                        <img src="{{asset('home/mobile/images/shape/shape_61.svg')}}" alt="" class="shape shape_02 me-lg-4">
                        <span>YOUR ACADEMY?</span>
                        <img src="{{asset('home/mobile/images/shape/shape_77.svg')}}" alt="" class="shape shape_03 ms-lg-4">
                    </h2>
                    <a href="{{ route('home.download') }}" class="btn-seventeen mt-50 lg-mt-30">Let’s Get Started</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /.fancy-banner-eight -->


@endsection
