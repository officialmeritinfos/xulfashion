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

    <div class="about_content-section bg-light-2  section-padding-120">
        <div class="container">
            <div class="row row--custom ">
                <div class="col-xxl-6 col-lg-5 col-md-6 col-7">
                    <div class="about_content-image-block ">
                        <div class="about_content-image content-image--mobile-width">
                            <img src="{{asset('home/image/storefront.svg')}}" alt="alternative text">
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-lg-7 col-md-10 col-auto" data-aos-duration="1000" data-aos="fade-left">
                    <div class="content">
                        <div class="content-text-block">
                            <h2 class="content-title heading-md text-black">Customizable Online Storefronts</h2>
                            <p>
                                With {{$siteName}}, fashion entrepreneurs and retailers are empowered to establish their unique
                                presence in the digital marketplace through our customizable online storefront feature.
                                While we currently support one official theme, users have the flexibility to tailor it to
                                suit their brand's personality and aesthetic. This flexibility makes {{$siteName}} a powerful
                                tool for showcasing products in a way that is both professional and unique to each designer
                                or retailer. We are also actively working on expanding theme options and allowing users to
                                upload their own themes, ensuring a truly personalized experience.
                            </p>
                            <div class="content-divider"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-lg-6 col-md-6" data-aos-duration="1000" data-aos="fade-left">
                    <div class="content">
                        <div class="content-text-block">
                            <p>
                                Our storefront theme is designed with conversion in mind. Each customizable element is
                                strategically placed to enhance the shopping experience and drive sales. Easy-to-navigate
                                product categories, prominent call-to-action buttons, and an organized layout help keep
                                shoppers engaged and encourage them to make purchases. You have the option to display
                                bestsellers, showcase new arrivals, and create featured product sections that attract attention.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-lg-6 col-md-6" data-aos-duration="1000" data-aos="fade-left">
                    <div class="content">
                        <div class="content-text-block">
                            <p>
                                As your business grows, your storefront grows with it. The customizable theme is built to
                                handle a diverse range of products, from a small collection of bespoke items to a full-scale
                                fashion line. You can add new product categories, adjust the layout to accommodate more items,
                                and even change the look and feel of your storefront as your brand evolves. Our ongoing theme
                                expansion plans and the upcoming custom theme upload feature ensure that {{$siteName}} remains
                                adaptable to your changing needs.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="about_content-section bg-light-2  section-padding-120">
        <div class="container">
            <div class="row row--custom ">

                <div class="col-xxl-6 col-lg-7 col-md-10 col-auto" data-aos-duration="1000" data-aos="fade-left">
                    <div class="content">
                        <div class="content-text-block">
                            <h2 class="content-title heading-md text-black">Integrated Booking System</h2>
                            <p>
                                The integrated booking system at {{$siteName}} is designed to streamline the booking experience for
                                both merchants and customers. This feature makes it easier for fashion designers, tailors, models,
                                and other merchants to manage appointments, while providing a user-friendly interface for
                                clients to book services. Currently, the booking system is seamlessly integrated into the
                                platform, offering a basic structure that efficiently handles scheduling and appointments.
                            </p>
                            <div class="content-divider"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-lg-5 col-md-6 col-7">
                    <div class="about_content-image-block ">
                        <div class="about_content-image content-image--mobile-width">
                            <img src="{{asset('home/image/booking.svg')}}" alt="alternative text">
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-lg-6 col-md-6" data-aos-duration="1000" data-aos="fade-left">
                    <div class="content">
                        <div class="content-text-block">
                            <p>
                                Our booking system simplifies the process of scheduling appointments for services such as
                                fittings, consultations, and photoshoots. Merchants can set up their availability, and customers
                                can book time slots that work best for them. The system automatically updates to reflect booked
                                slots, reducing the risk of double-bookings and miscommunications. With just a few clicks,
                                both merchants and clients can easily manage their appointments, making the whole process smooth and efficient.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-lg-6 col-md-6" data-aos-duration="1000" data-aos="fade-left">
                    <div class="content">
                        <div class="content-text-block">
                            <p>
                                One of the most convenient aspects of our integrated booking system is the automated
                                reminder feature. Once a customer schedules an appointment, they receive confirmation
                                emails and reminders to ensure they don’t miss their bookings. This feature reduces
                                no-shows and last-minute cancellations, helping merchants maintain a more consistent and
                                reliable schedule. Automated reminders are customizable, allowing merchants to adjust
                                the timing and content of notifications based on their needs.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="about_content-section bg-light-2  section-padding-120">
        <div class="container">
            <div class="row row--custom ">
                <div class="col-xxl-12 col-lg-12 col-md-12 col-12">
                    <div class="about_content-image-block ">
                        <div class="about_content-image content-image--mobile-width">
                            <img src="{{asset('home/image/checkout.svg')}}" alt="alternative text">
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-lg-6 col-md-6" data-aos-duration="1000" data-aos="fade-left">
                    <div class="content">
                        <div class="content-text-block">
                            <h4 class="content-title heading-sm text-black">Online Checkout</h4>
                            <p>
                                {{$siteName}} simplifies the online checkout process, allowing customers to make secure payments directly through the platform.
                                With online checkout, customers can:
                            </p>
                            <ul>
                                <li><strong>Complete Purchases from Anywhere:</strong> They can finalize their purchases directly on the {{$siteName}} platform,
                                    giving them the flexibility to shop from anywhere.</li>
                                <li><strong>Multiple Payment Methods:</strong> We support a variety of payment options to suit different preferences,
                                    enhancing convenience and broadening your customer base.</li>
                                <li><strong>Transaction Tracking:</strong> Both customers and merchants can track orders and view their transaction
                                    history at any time, adding an extra layer of transparency and control.</li>
                            </ul>
                            <p>This feature is optimized to be user-friendly, ensuring a smooth and seamless experience for your customers
                                while they shop online.</p>

                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-lg-6 col-md-6" data-aos-duration="1000" data-aos="fade-left">
                    <div class="content">
                        <div class="content-text-block">

                            <h4 class="content-title heading-sm text-black">Offline Checkout on Whatsapp</h4>
                            <p>
                                In addition to online payments, {{$siteName}} supports offline checkouts, providing the option for customers to make
                                purchases and communicate through WhatsApp. This feature enables you to:
                            </p>
                            <ul>
                                <li><strong>Maintain Direct Customer Communication:</strong> Customers can place orders via WhatsApp, giving them
                                    a personal touch and immediate access to communicate with you directly for any specific requests or questions.</li>
                                <li><strong>Customized Payment Arrangements:</strong> Customers can pay offline through cash or bank transfers,
                                    offering flexibility for those who prefer not to make online payments.</li>
                                <li><strong>Accessible and Convenient:</strong> Especially useful for local customers who prefer in-person
                                    interactions or are more familiar with WhatsApp for conducting business.</li>
                            </ul>
                            <p>By incorporating both online and offline checkout options, {{$siteName}} caters to a wide array of customer
                                preferences, enabling a seamless shopping experience that’s tailored to everyone’s needs.</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
