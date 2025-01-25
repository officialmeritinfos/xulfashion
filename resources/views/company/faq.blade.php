@extends('company.layout.base')
@section('content')


    <!--
=====================================================
FAQ Section Two for Xulfashion
=====================================================
-->
    <div class="faq-section-two position-relative mt-225 lg-mt-200 sm-mt-150 mb-180 lg-mb-80">
        <div class="container">
            <!-- Account Section -->
            <div class="row">
                <div class="col-lg-5">
                    <div class="title-two mb-40">
                        <div class="pointer" style="background: #FFCE52;">Account <img src="{{asset('home/mobile/images/shape/shape_25.svg')}}" alt=""></div>
                        <h2>Questions & Answers</h2>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="accordion accordion-style-two ms-xxl-4" id="accordionThree">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    What is Xulfashion?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionThree">
                                <div class="accordion-body">
                                    Xulfashion is a platform dedicated to connecting fashion creators like designers, tailors, and models with shoppers and clients, offering a wide range of services from online stores to bookings and more.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Who can use Xulfashion?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionThree">
                                <div class="accordion-body">
                                    Xulfashion is designed for fashion enthusiasts, business owners in the fashion industry, and anyone looking for quality fashion services, including shoppers, models, designers, and tailors.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Is Xulfashion available globally?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionThree">
                                <div class="accordion-body">
                                    Yes, Xulfashion is accessible worldwide, allowing users from various regions to connect with fashion creators and access fashion products.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Section -->
            <div class="row mt-90 lg-mt-60">
                <div class="col-lg-5">
                    <div class="title-two mb-40">
                        <div class="pointer" style="background: #FF4BD8;">Financial <img src="{{asset('home/mobile/images/shape/shape_26.svg')}}" alt=""></div>
                        <h2>Pricing Plan & Billing</h2>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="accordion accordion-style-two ms-xxl-4" id="accordionFour">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneA" aria-expanded="false" aria-controls="collapseOneA">
                                    How much does it cost to join Xulfashion?
                                </button>
                            </h2>
                            <div id="collapseOneA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    Creating an account and joining Xulfashion is free. Additional fees may apply depending on the services you use, such as transaction fees for sales.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoA" aria-expanded="false" aria-controls="collapseTwoA">
                                    What payment methods are accepted on Xulfashion?
                                </button>
                            </h2>
                            <div id="collapseTwoA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    Xulfashion accepts a variety of payment methods, including credit/debit cards, bank transfers, and mobile money options, depending on your region.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeA" aria-expanded="false" aria-controls="collapseThreeA">
                                    Are there transaction fees on Xulfashion?
                                </button>
                            </h2>
                            <div id="collapseThreeA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    Yes, Xulfashion applies a small transaction fee for purchases made through the platform, which helps cover operational costs and improve the service.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Support & Privacy Section -->
            <div class="row mt-90 lg-mt-60">
                <div class="col-lg-5">
                    <div class="title-two mb-40">
                        <div class="pointer" style="background: #00D9B2;">Common <img src="{{asset('home/mobile/images/shape/shape_27.svg')}}" alt=""></div>
                        <h2>Support & Privacy</h2>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="accordion accordion-style-two ms-xxl-4" id="accordionFive">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneB" aria-expanded="false" aria-controls="collapseOneB">
                                    How does Xulfashion ensure quality?
                                </button>
                            </h2>
                            <div id="collapseOneB" class="accordion-collapse collapse" data-bs-parent="#accordionFive">
                                <div class="accordion-body">
                                    Xulfashion requires sellers to adhere to quality standards, and we encourage customer feedback and reviews to maintain high-quality products and services.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoB" aria-expanded="false" aria-controls="collapseTwoB">
                                    Is my personal information secure on Xulfashion?
                                </button>
                            </h2>
                            <div id="collapseTwoB" class="accordion-collapse collapse" data-bs-parent="#accordionFive">
                                <div class="accordion-body">
                                    Absolutely. Xulfashion uses encryption and strict data protection measures to ensure all personal and payment information is kept secure.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeB" aria-expanded="false" aria-controls="collapseThreeB">
                                    Does Xulfashion offer support for both designers and shoppers?
                                </button>
                            </h2>
                            <div id="collapseThreeB" class="accordion-collapse collapse" data-bs-parent="#accordionFive">
                                <div class="accordion-body">
                                    Yes, Xulfashion provides dedicated support for both designers and shoppers to ensure a seamless experience on the platform.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_28.svg')}}" alt="" class="shapes shape_01">
    </div>
    <!-- /.faq-section-two -->



    <!--
   =====================================================
       Fancy Banner Two
   =====================================================
   -->
    <div class="fancy-banner-two pt-120 lg-pt-80 pb-150 xl-pb-120 lg-pb-80 position-relative z-1">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-7 m-auto text-center">
                    <h2>Thousands of Fashion & Beauty Businesses Trust {{$siteName}}. Join Them Today!</h2>
                    <a href="{{ route('mobile.register') }}" class="btn-six">Start Your Journey Now!</a>
                </div>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_20.svg')}}" alt="" class="shapes shape_01">
        <img src="{{asset('home/mobile/images/shape/shape_21.svg')}}" alt="" class="shapes shape_02">
    </div>


@endsection
