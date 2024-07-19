@extends('company.layout.base')
@section('content')

    <!--~~~~~~~~~~~~~~~~~~~~~~~~
     navbar-
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="inner_banner-section">
        <img class="inner_banner-background-image" src="{{asset('home/image/common/inner-bg.png')}}" alt="image alt">
        <div class="container">
            <div class="inner_banner-content-block">
                <h3 class="inner_banner-title">{{$pageName}}</h3>
                <ul class="banner__page-navigator">
                    <li>
                        <a href="{{route('home.index')}}">Home</a>
                    </li>
                    <li class="active">
                        <a href="#">
                            {{$pageName}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~
    About : Banner Section
~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="about_banner-section">
        <div class="container">
            <div class="row justify-content-center row--custom">
                <div class="col-12">
                    <div class="row banner_image-row padding-top-100">
                        <div class="col-xs-4 col-4">
                            <div class="single-image-1">
                                <img src="{{asset('home/image/uchez.webp')}}" alt="alternative text">
                            </div>
                        </div>
                        <div class="col-xs-4 col-4">
                            <div class="single-image-2">
                                <img src="{{asset('home/image/ugonnabarr.webp')}}" alt="alternative text">
                            </div>
                        </div>
                        <div class="col-xs-4 col-4">
                            <div class="single-image-3">
                                <img src="{{asset('home/image/coo.webp')}}" alt="alternative text">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~
    ABout : Brand Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

    <!-- ~~~~~~~~~~~~~~~~~~~~~
  About : Content Section
~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="about_content-section bg-light-2  section-padding-120">
        <div class="container">
            <div class="row row--custom ">
                <div class="col-xxl-6 col-lg-5 col-md-6 col-7">
                    <div class="about_content-image-block ">
                        <div class="about_content-image content-image--mobile-width">
                            <img src="{{asset('home/image/about/video-image.png')}}" alt="alternative text">
                        </div>
                        <a href="#" data-fancybox class="btn-play absolute-center btn-play">
                            <i class="fa-solid fa-play"></i>
                        </a>
                    </div>
                </div>
                <div class="col-xxl-6 col-lg-7 col-md-10 col-auto" data-aos-duration="1000" data-aos="fade-left">
                    <div class="content">
                        <div class="content-text-block">
                            <h2 class="content-title heading-md text-black">
                                Our vision is to be recognized as the leading digital platform for the fashion industry
                            </h2>
                            <p>
                                At Xulfashion, we aim to redefine the fashion industry by integrating advanced technology that enhances both
                                creator capabilities and consumer experiences. Our platform is designed to bridge the gap between
                                traditional fashion commerce and digital innovation, ensuring seamless transactions and expansive
                                market reach. We are committed to building a trustworthy and innovative community, where fashion
                                and technology progress together.
                            </p>
                            <div class="content-divider"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~
  About : Fact Section
~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="about_fact-section  section-padding-120">
        <div class="container">
            <div class="row ">
                <div class="col-12 col-lg-12 col-md-12">
                    <div class="content">
                        <div class="content-text-block">
                            <h2 class="content-title heading-md text-black">
                                The Genesis of {{$siteName}} began in 2023
                            </h2>

                            <p>
                                when our founders recognized a gap in the market for a specialized platform catering solely to
                                the fashion industry. Observing the challenges that independent fashion creators faced in
                                reaching a broader audience, they set out to create a solution that would also streamline
                                the consumer's shopping experience. The journey started with a simple idea: a one-stop-shop
                                for all things fashion, providing tools and resources that support both creators and consumers.</p>

                            <p>As they delved deeper into the industry, they found that many talented designers and boutique
                                stores lacked the technical resources to effectively showcase their collections online.
                                This insight led to the development of Xulfashion, designed to empower fashion professionals
                                with a robust, intuitive platform that not only enhances visibility but also fosters direct
                                engagement with fashion enthusiasts worldwide.</p>

                            <p>From the outset, the vision was clear: to democratize fashion e-commerce by making it accessible,
                                scalable, and economically feasible for fashion designers and retailers of all sizes.
                                Our platform integrates cutting-edge technology with a deep understanding of the fashion
                                market's nuances, offering tailored features like virtual try-ons, personalized storefronts,
                                and real-time fashion analytics.</p>
                            <p>Today, Xulfashion stands as a beacon for innovation in the fashion industry, bridging geographical
                                and cultural divides to bring a diverse range of fashion to a global audience. As we continue
                                to evolve and expand our offerings, our commitment remains steadfast: to revolutionize the
                                fashion industry by providing a marketplace that is as dynamic and vibrant as the fashion it hosts.</p>
                        </div>
                        <div class="content-button-block">
                            <a href="{{route('home.index')}}#join-waitlist" class="btn-masco btn-primary rounded-pill btn-fill--up"><span>Join Us</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~
   About : Feature Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="about_feature-section section-padding-120 bg-light-2">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-8 col-sm-10 col-xs-10">
                    <div class="section-heading">
                        <h2 class="section-heading__title heading-md text-black">Our core values that drive everything we do</h2>
                    </div>
                </div>
            </div>
            <div class="row feature-widget-7-row  ">
                <div class="col-lg-4 col-md-6 col-xs-8 col-9">
                    <div class="feature-widget-7">
                        <div class="feature-widget-7__icon-wrapper">
                            <img src="{{asset('home/image/about/feature-icon-1.svg')}}" alt="feature icon">
                        </div>
                        <div class="feature-widget-7__body">
                            <h4 class="feature-widget-7__title">Innovation</h4>
                            <p>
                                At Xulfashion, innovation is the cornerstone of our operations. We are committed to continually
                                evolving our platform with cutting-edge technologies and features that not only meet but
                                exceed the expectations of fashion creators and consumers.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-xs-8 col-9">
                    <div class="feature-widget-7">
                        <div class="feature-widget-7__icon-wrapper">
                            <img src="{{asset('home/image/about/feature-icon-2.svg')}}" alt="feature icon">
                        </div>
                        <div class="feature-widget-7__body">
                            <h4 class="feature-widget-7__title">Customer Centricity</h4>
                            <p>
                                Our platform is built around the needs and preferences of our users. We listen to the
                                voices of our community to tailor experiences that are both rewarding and inspiring. We are
                                not just building what we feel you need, rather we are building what you said you need.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-xs-8 col-9">
                    <div class="feature-widget-7">
                        <div class="feature-widget-7__icon-wrapper">
                            <img src="{{asset('home/image/about/feature-icon-3.svg')}}" alt="feature icon">
                        </div>
                        <div class="feature-widget-7__body">
                            <h4 class="feature-widget-7__title">Integrity</h4>
                            <p>
                                Integrity forms the foundation of all our interactions and decisions. From transparent
                                business practices to honest communication, we strive to build trust with our stakeholders.
                                This value is critical in fostering long-term relationships and maintaining a reputable and reliable marketplace.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-xs-8 col-9">
                    <div class="feature-widget-7">
                        <div class="feature-widget-7__icon-wrapper">
                            <img src="{{asset('home/image/about/feature-icon-4.svg')}}" alt="feature icon">
                        </div>
                        <div class="feature-widget-7__body">
                            <h4 class="feature-widget-7__title">Diversity</h4>
                            <p>
                                Xulfashion embraces diversity in all its forms—be it in our team, our platform's offerings,
                                or our global user base. We believe that celebrating diverse perspectives and backgrounds
                                fuels creativity and innovation, which are essential for driving the fashion industry forward.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-xs-8 col-9">
                    <div class="feature-widget-7">
                        <div class="feature-widget-7__icon-wrapper">
                            <img src="{{asset('home/image/about/feature-icon-5.svg')}}" alt="feature icon">
                        </div>
                        <div class="feature-widget-7__body">
                            <h4 class="feature-widget-7__title">Sustainability </h4>
                            <p>
                                We are committed to promoting sustainable practices within the fashion industry through
                                our platform. By encouraging the adoption of eco-friendly materials and supporting sustainable
                                fashion brands, we contribute to the well-being of the environment and advocate for responsible
                                fashion consumption.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-xs-8 col-9">
                    <div class="feature-widget-7">
                        <div class="feature-widget-7__icon-wrapper">
                            <img src="{{asset('home/image/about/feature-icon-6.svg')}}" alt="feature icon">
                        </div>
                        <div class="feature-widget-7__body">
                            <h4 class="feature-widget-7__title">Collaboration</h4>
                            <p>
                                {{$siteName}} is built on the foundation of collaboration - the early founders with the stakeholders
                                and early-stage employees, all worked based on collaboration. We are striving today too is because we collaborate with
                                key players in the industry and our clients.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    About  : FAQ Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="about_faq-section section-padding-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-md-8">
                    <div class="section-heading section-heading text-center">
                        <h2 class="section-heading__title heading-md text-black">Frequently asked questions about our platform</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="accordion-style-1" id="home-1-faq">
                        <!-- FAQ 1 -->
                        <div class="accordion-item">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                                Q. What is Xulfashion?
                            </button>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#home-1-faq">
                                <div class="accordion-item__body">
                                    Xulfashion is an innovative platform dedicated to transforming the fashion industry by connecting fashion creators and shoppers worldwide. We provide customizable online storefronts, integrated booking systems, and secure transactions to empower fashion businesses.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ 2 -->
                        <div class="accordion-item">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                                Q. How does the booking system work on Xulfashion?
                            </button>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#home-1-faq">
                                <div class="accordion-item__body">
                                    Our booking system allows fashion service providers, like tailors and models, to manage appointments efficiently. It features real-time availability, automated reminders, and easy scheduling to enhance both provider and customer experiences.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ 3 -->
                        <div class="accordion-item">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                                Q. Can I create a customized storefront on Xulfashion?
                            </button>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#home-1-faq">
                                <div class="accordion-item__body">
                                    Yes, Xulfashion allows you to create a customized online storefront. You can choose from a variety of templates, add custom domains, and personalize your shop to match your brand identity.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ 4 -->
                        <div class="accordion-item">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                                Q. What security measures does Xulfashion offer for transactions?
                            </button>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#home-1-faq">
                                <div class="accordion-item__body">
                                    Xulfashion utilizes a secure escrow system for all transactions to ensure that both buyers and sellers are protected. This system helps to build trust and confidence in our platform.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ 5 -->
                        <div class="accordion-item">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq5" aria-expanded="false" aria-controls="faq5">
                                Q. How do I handle returns and refunds on Xulfashion?
                            </button>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#home-1-faq">
                                <div class="accordion-item__body">
                                    Returns and refunds are managed through our comprehensive policy framework, which supports
                                    both merchants and customers in handling disputes fairly and efficiently. We equally
                                    allow merchants to control their refund and return policies - putting an escrow system
                                    as a check to prevent abuse.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ 6 -->
                        <div class="accordion-item">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq6" aria-expanded="false" aria-controls="faq6">
                                Q. How can I track my performance on Xulfashion?
                            </button>
                            <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#home-1-faq">
                                <div class="accordion-item__body">
                                    Xulfashion offers advanced analytics tools that allow you to track sales, customer engagement, and other key metrics. These insights can help you make informed decisions to grow your business.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ 7 -->
                        <div class="accordion-item">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq7" aria-expanded="false" aria-controls="faq7">
                                Q. What support does Xulfashion offer to its users?
                            </button>
                            <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#home-1-faq">
                                <div class="accordion-item__body">
                                    Our platform provides 24/7 customer support to address any issues or queries. We ensure that all users receive the assistance they need to operate smoothly.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-button">
                <a href="{{route('home.index')}}#join-waitlist" class="btn-masco rounded-pill btn-fill--up">Join the Wait-list now</a>
            </div>
        </div>
    </div>

@endsection
