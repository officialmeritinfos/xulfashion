@extends('company.layout.base')
@section('content')

    <div class="inner_banner-section">
        <img class="inner_banner-background-image" src="{{asset('home/image/common/inner-bg.png')}}" alt="image alt">
        <div class="container">
            <div class="inner_banner-content-block">
                <h3 class="inner_banner-title">{{$pageName}}</h3>
                <ul class="banner__page-navigator">
                    <li>
                        <a href="{{url('/')}}">Home</a>
                    </li>
                    <li class="active">
                        <a href="{{url()->current()}}">
                            {{$pageName}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="faq-section_main section-padding-120">
        <div class="container">
            <div class="row row--custom justify-content-center">
                <div class="col-lg-10">
                    <div class="accordion-style-1" id="faq-1_faq">

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item" aria-expanded="false" aria-controls="faq-1_faq-item">
                                Q. What is {{$siteName}}?
                            </button>
                            <div id="faq-1_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    {{$siteName}} is a platform dedicated to connecting fashion creators like designers, tailors, and models with shoppers and clients, offering a wide range of services from online stores to bookings and much more.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-2_faq-item" aria-expanded="false" aria-controls="faq-2_faq-item">
                                Q. Who can use {{$siteName}}?
                            </button>
                            <div id="faq-2_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    {{$siteName}} is designed for fashion enthusiasts, business owners in the fashion industry, and anyone looking for quality fashion services, including shoppers, models, designers, and tailors.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-3_faq-item" aria-expanded="false" aria-controls="faq-3_faq-item">
                                Q. Is {{$siteName}} available globally?
                            </button>
                            <div id="faq-3_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    Yes, {{$siteName}} is accessible worldwide, allowing users from various regions to connect with fashion creators and access fashion products.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-4_faq-item" aria-expanded="false" aria-controls="faq-4_faq-item">
                                Q. Is there a mobile app for {{$siteName}}?
                            </button>
                            <div id="faq-4_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    Yes, {{$siteName}} offers a mobile app for both shoppers and merchants, making it easy to access the platform from anywhere.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-5_faq-item" aria-expanded="false" aria-controls="faq-5_faq-item">
                                Q. How much does it cost to join {{$siteName}}?
                            </button>
                            <div id="faq-5_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    Creating an account and joining {{$siteName}} is free. Additional fees may apply depending on the services you use, such as transaction fees for sales.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-6_faq-item" aria-expanded="false" aria-controls="faq-6_faq-item">
                                Q. What payment methods are accepted on {{$siteName}}?
                            </button>
                            <div id="faq-6_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    {{$siteName}} accepts a variety of payment methods, including credit/debit cards, bank transfers, and mobile money options, depending on your region.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-7_faq-item" aria-expanded="false" aria-controls="faq-7_faq-item">
                                Q. Does {{$siteName}} offer support for both designers and shoppers?
                            </button>
                            <div id="faq-7_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    Yes, {{$siteName}} provides dedicated support for both designers and shoppers to ensure a seamless experience on the platform.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-8_faq-item" aria-expanded="false" aria-controls="faq-8_faq-item">
                                Q. Is my personal information secure on {{$siteName}}?
                            </button>
                            <div id="faq-8_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    Absolutely. {{$siteName}} uses encryption and strict data protection measures to ensure that all personal and payment information is kept secure.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-9_faq-item" aria-expanded="false" aria-controls="faq-9_faq-item">
                                Q. Can I use {{$siteName}} on both desktop and mobile devices?
                            </button>
                            <div id="faq-9_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    Yes, {{$siteName}} is fully optimized for desktop, tablet, and mobile devices, ensuring a smooth experience across all platforms.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-10_faq-item" aria-expanded="false" aria-controls="faq-10_faq-item">
                                Q. What types of fashion services are available on {{$siteName}}?
                            </button>
                            <div id="faq-10_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    {{$siteName}} offers a variety of services, including fashion design, tailoring, custom fittings, online shopping, and booking services with fashion professionals.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-11_faq-item" aria-expanded="false" aria-controls="faq-11_faq-item">
                                Q. How can I sign up as a fashion designer on {{$siteName}}?
                            </button>
                            <div id="faq-11_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    Signing up as a fashion designer on {{$siteName}} is easy. Simply go to the registration page, select the designer option, fill out the required details, and start showcasing your work.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-12_faq-item" aria-expanded="false" aria-controls="faq-12_faq-item">
                                Q. Can I manage multiple stores with one account?
                            </button>
                            <div id="faq-12_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    No, {{$siteName}} allows you to manage only one storefront from one account, however, we are
                                    adding more features to allow you manage your storefront for different branches.<br/>
                                    <b>Note:</b> If you believe we should support multiple storefronts, then fill our our
                                    features request and let others vote on it.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-13_faq-item" aria-expanded="false" aria-controls="faq-13_faq-item">
                                Q. How can I receive payments on {{$siteName}}?
                            </button>
                            <div id="faq-13_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    Payments on {{$siteName}} are processed directly through the platform. You'll need to set up a payout account in your profile to receive funds.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-14_faq-item" aria-expanded="false" aria-controls="faq-14_faq-item">
                                Q. Are there any transaction fees on {{$siteName}}?
                            </button>
                            <div id="faq-14_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    Yes, {{$siteName}} applies a small transaction fee for purchases made through the platform, which helps cover operational costs and improve the service.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-15_faq-item" aria-expanded="false" aria-controls="faq-15_faq-item">
                                Q. What is the {{$siteName}} Escrow system?
                            </button>
                            <div id="faq-15_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    The {{$siteName}} Escrow system ensures secure transactions by holding payments until the buyer confirms receipt and satisfaction with the purchase.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-16_faq-item" aria-expanded="false" aria-controls="faq-16_faq-item">
                                Q. How does {{$siteName}} ensure the quality of fashion products?
                            </button>
                            <div id="faq-16_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    {{$siteName}} requires sellers to adhere to quality standards, and we encourage customer feedback and reviews to help maintain high-quality products and services.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-17_faq-item" aria-expanded="false" aria-controls="faq-17_faq-item">
                                Q. How can I customize my online storefront on {{$siteName}}?
                            </button>
                            <div id="faq-17_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    You can customize your storefront by selecting themes, adding logos, and organizing product listings to create a unique brand experience.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-18_faq-item" aria-expanded="false" aria-controls="faq-18_faq-item">
                                Q. What is {{$siteName}}'s Integrated Booking System?
                            </button>
                            <div id="faq-18_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    {{$siteName}}'s booking system allows customers to schedule appointments with fashion professionals, such as models and tailors, directly through the app.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-19_faq-item" aria-expanded="false" aria-controls="faq-19_faq-item">
                                Q. Can I cancel an order after it's been placed?
                            </button>
                            <div id="faq-19_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    Yes, orders can be canceled before they are processed. For further details, you can review your merchant's cancellation/refund policy.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-20_faq-item" aria-expanded="false" aria-controls="faq-20_faq-item">
                                Q. Is there customer support for issues related to orders?
                            </button>
                            <div id="faq-20_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    Yes, {{$siteName}} offers 24/7 customer support to help resolve any issues related to orders and provide assistance with general inquiries.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-27_faq-item" aria-expanded="false" aria-controls="faq-27_faq-item">
                                Q. Is there a fee to list products on {{$siteName}}?
                            </button>
                            <div id="faq-27_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                                <div class="accordion-item__body">
                                    Listing products on {{$siteName}} is free, though transaction fees apply for each completed sale made through the platform.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="section-button">
                <a href="{{route('home.contact')}}" class="btn-masco btn-fill--up rounded-pill"><span>Still, have any questions? Contact us</span></a>
            </div>
        </div>
    </div>

@endsection
