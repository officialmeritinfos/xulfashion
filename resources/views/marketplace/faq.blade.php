@extends('marketplace.layout.base')
@section('content')

    <!-- Content wrapper start -->
    <div class="content-wrapper">

        <!-- Breadcrumb start -->
        <div class="breadcrumb-wrap bg-f br-bg-1">
            <div class="overlay op-5 bg-black"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-10 offset-md-1">
                        <div class="breadcrumb-title">
                            <h2>{{$pageName}}</h2>
                            <ul class="breadcrumb-menu list-style">
                                <li><a href="{{route('marketplace.index',['country'=>$iso3])}}">Home </a></li>
                                <li>{{$pageName}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bredcrumb end -->

        <!-- FAQ Section Start -->
        <section class="faq-wrap ptb-100">
            <div class="container">
                <div class="row gx-5">
                    <div class="col-xl-6 col-lg-6">
                        <div class="faq-content">
                            <div class="faq-item">
                                <h5>01. What is {{$siteName}}?</h5>
                                <p>{{$siteName}} is a unique platform that connects fashion designers with global and local clients. We offer a marketplace for fashion ads and a shopify-like section for designers to create stores and sell their products online.</p>
                            </div>

                            <div class="faq-item">
                                <h5>02. How can fashion designers benefit from {{$siteName}}?</h5>
                                <p>Designers can reach a wider audience, showcase their work, receive bookings from local clients, and sell their products directly through our platform.</p>
                            </div>

                            <div class="faq-item">
                                <h5>03. How do I sign up as a designer on {{$siteName}}?</h5>
                                <p>Simply visit our website, click on the 'List your business' button, and fill out the registration form with your details to get started.</p>
                            </div>

                            <div class="faq-item">
                                <h5>04. What types of fashion products can be sold on {{$siteName}}?</h5>
                                <p>You can sell clothing, accessories, footwear, and custom fashion items. Essentially, any fashion-related product is welcome.</p>
                            </div>

                            <div class="faq-item">
                                <h5>05. Is there a fee to join {{$siteName}}?</h5>
                                <p>Joining {{$siteName}} is free. We do charge a small commission on sales made through our platform to cover our operational costs.</p>
                            </div>

                            <div class="faq-item">
                                <h5>06. Can clients book designers directly through {{$siteName}}?</h5>
                                <p>Yes, clients can browse designer profiles and book appointments or request custom designs directly through our platform.</p>
                            </div>

                            <div class="faq-item">
                                <h5>07. How do I list an ad on {{$siteName}}?</h5>
                                <p>After signing up, go to your dashboard, click on 'Create Ad,' and fill in the details about your fashion services or products.</p>
                            </div>

                            <div class="faq-item">
                                <h5>08. How are payments handled on {{$siteName}}?</h5>
                                <p>Payments are processed securely through our platform. We support various payment methods to ensure convenience for both designers and customers.</p>
                            </div>

                            <div class="faq-item">
                                <h5>09. Can I track the performance of my ads?</h5>
                                <p>Yes, our dashboard provides insights and analytics on the number of views, clicks, and conversions for your ads.</p>
                            </div>

                            <div class="faq-item">
                                <h5>10. Is there customer support available?</h5>
                                <p>Absolutely. Our support team is available 24/7 to assist you with any questions or issues you might have.</p>
                            </div>

                            <div class="faq-item">
                                <h5>11. Can I customize my store on {{$siteName}}?</h5>
                                <p>Yes, you can customize your store with your branding, images, and descriptions to reflect your unique style.</p>
                            </div>

                            <div class="faq-item">
                                <h5>12. Are there any promotional tools available?</h5>
                                <p>We offer various promotional tools and tips to help you market your products and reach more customers.</p>
                            </div>

                            <div class="faq-item">
                                <h5>13. How do I get paid for my sales?</h5>
                                <p>Payments for sales are transferred to your bank account or preferred payment method, typically within a few days after a sale is completed.</p>
                            </div>

                            <div class="faq-item">
                                <h5>14. Can I manage multiple ads at once?</h5>
                                <p>Yes, you can create, edit, and manage multiple ads from your dashboard efficiently.</p>
                            </div>

                            <div class="faq-item">
                                <h5>15. What if I need help setting up my store?</h5>
                                <p>Our support team can guide you through the setup process, and we also provide helpful resources and tutorials.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="faq-content">
                            <div class="faq-item">
                                <h5>16. Are there any restrictions on the type of fashion products I can sell?</h5>
                                <p>As long as your products are fashion-related and comply with our terms of service, you can list them on {{$siteName}}.</p>
                            </div>

                            <div class="faq-item">
                                <h5>17. How do I update my profile information?</h5>
                                <p>You can update your profile information anytime by logging into your account and accessing your profile settings.</p>
                            </div>

                            <div class="faq-item">
                                <h5>18. Can clients leave reviews for designers?</h5>
                                <p>Yes, clients can leave reviews and ratings for designers, which helps build credibility and attract more customers.</p>
                            </div>

                            <div class="faq-item">
                                <h5>19. How do I ensure my store stands out?</h5>
                                <p>Use high-quality images, detailed descriptions, and keep your store updated with the latest fashion trends and products.</p>
                            </div>

                            <div class="faq-item">
                                <h5>20. Can I run promotions or discounts on my store?</h5>
                                <p>Yes, you can run promotions and offer discounts to attract more customers and boost sales.</p>
                            </div>

                            <div class="faq-item">
                                <h5>21. Is {{$siteName}} available internationally?</h5>
                                <p>Yes, {{$siteName}} is a global platform, allowing designers from around the world to connect with clients everywhere.</p>
                            </div>

                            <div class="faq-item">
                                <h5>22. What happens if I encounter a technical issue?</h5>
                                <p>Our technical support team is always on standby to resolve any issues you might encounter promptly.</p>
                            </div>

                            <div class="faq-item">
                                <h5>23. Can I communicate with my clients through {{$siteName}}?</h5>
                                <p>Yes, our messaging system allows you to communicate directly with clients for better coordination and service delivery.</p>
                            </div>

                            <div class="faq-item">
                                <h5>24. How do I know if a booking request is legitimate?</h5>
                                <p>We have measures in place to verify bookings and reduce the risk of fraud. Always communicate through our platform to ensure security.</p>
                            </div>

                            <div class="faq-item">
                                <h5>25. Can I see how many times my store has been viewed?</h5>
                                <p>Yes, your dashboard will show you the number of views and other engagement metrics for your store.</p>
                            </div>

                            <div class="faq-item">
                                <h5>26. Are there any advertising opportunities within {{$siteName}}?</h5>
                                <p>Yes, we offer advertising opportunities to help you promote your store and reach a larger audience.</p>
                            </div>

                            <div class="faq-item">
                                <h5>27. What should I do if I receive a negative review?</h5>
                                <p>Take it as constructive feedback, respond professionally, and use it to improve your services.</p>
                            </div>

                            <div class="faq-item">
                                <h5>28. Can I list both ready-made and custom fashion items?</h5>
                                <p>Yes, you can list ready-made items for sale and also offer custom design services to clients.</p>
                            </div>

                            <div class="faq-item">
                                <h5>29. How often should I update my store?</h5>
                                <p>Regular updates with new products and promotions can help keep your store engaging and attract repeat customers.</p>
                            </div>

                            <div class="faq-item">
                                <h5>30. How does {{$siteName}} handle disputes between designers and clients?</h5>
                                <p>We provide a mediation service to help resolve disputes fairly and efficiently, ensuring a positive experience for both parties.</p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- FAQ Section End -->

    </div>
    <!-- Content wrapper end -->


@endsection
