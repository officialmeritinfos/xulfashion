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
                            <h4>{{$pageName}}</h4>
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
        <section class="faq-wrap ptb-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="faq-content">
                            <p>Last Update: 5th May, 2024</p>

                            <p>At {{$siteName}}, we are committed to protecting your privacy. This Privacy Policy outlines how we collect, use, disclose, and safeguard your information when you visit our website and use our services. Please read this Privacy Policy carefully. If you do not agree with the terms of this Privacy Policy, please do not access the site.</p>

                            <h4>1. Information We Collect</h4>
                            <p>We may collect information about you in a variety of ways. The information we may collect on the Site includes:</p>
                            <h5>Personal Data</h5>
                            <p>Personally identifiable information, such as your name, shipping address, email address, and telephone number, and demographic information, such as your age, gender, hometown, and interests, that you voluntarily give to us when you register with the Site or our mobile application, or when you choose to participate in various activities related to the Site and our mobile application, such as online chat and message boards.</p>

                            <h5>Derivative Data</h5>
                            <p>Information our servers automatically collect when you access the Site, such as your IP address, your browser type, your operating system, your access times, and the pages you have viewed directly before and after accessing the Site.</p>

                            <h5>Financial Data</h5>
                            <p>Financial information, such as data related to your payment method (e.g., valid credit card number, card brand, expiration date) that we may collect when you purchase, order, return, exchange, or request information about our services from the Site. We store only very limited, if any, financial information that we collect. Otherwise, all financial information is stored by our payment processor, [Payment Processor], and you are encouraged to review their privacy policy and contact them directly for responses to your questions.</p>

                            <h5>Mobile Device Data</h5>
                            <p>Device information, such as your mobile device ID, model, and manufacturer, and information about the location of your device, if you access the Site from a mobile device.</p>

                            <h5>Third-Party Data</h5>
                            <p>Information from third parties, such as personal information or network friends, if you connect your account to the third party and grant the Site permission to access this information.</p>

                            <h4>2. Use of Your Information</h4>
                            <p>Having accurate information about you permits us to provide you with a smooth, efficient, and customized experience. Specifically, we may use information collected about you via the Site to:</p>
                            <ul>
                                <li class="list-item">Create and manage your account.</li>
                                <li class="list-item">Process your transactions and send you related information, including purchase confirmations and invoices.</li>
                                <li class="list-item">Email you regarding your account or order.</li>
                                <li class="list-item">Fulfill and manage purchases, orders, payments, and other transactions related to the Site.</li>
                                <li class="list-item">Provide you with customer support.</li>
                                <li class="list-item">Send you a newsletter.</li>
                                <li class="list-item">Request feedback and contact you about your use of the Site.</li>
                                <li class="list-item">Resolve disputes and troubleshoot problems.</li>
                                <li class="list-item">Respond to product and customer service requests.</li>
                                <li class="list-item">Administer sweepstakes, promotions, and contests.</li>
                                <li class="list-item">Enable user-to-user communications.</li>
                                <li class="list-item">Compile anonymous statistical data and analysis for use internally or with third parties.</li>
                                <li class="list-item">Prevent fraudulent transactions, monitor against theft, and protect against criminal activity.</li>
                                <li class="list-item">Assist law enforcement and respond to subpoenas.</li>
                                <li class="list-item">Generate a personal profile about you to make future visits to the Site more personalized.</li>
                                <li class="list-item">Increase the efficiency and operation of the Site.</li>
                                <li class="list-item">Monitor and analyze usage and trends to improve your experience with the Site.</li>
                                <li class="list-item">Notify you of updates to the Site.</li>
                                <li class="list-item">Offer new products, services, mobile applications, and/or recommendations to you.</li>
                                <li class="list-item">Perform other business activities as needed.</li>
                            </ul>

                            <h4>3. Disclosure of Your Information</h4>
                            <p>We may share information we have collected about you in certain situations. Your information may be disclosed as follows:</p>
                            <h5>By Law or to Protect Rights</h5>
                            <p>If we believe the release of information about you is necessary to respond to legal process, to investigate or remedy potential violations of our policies, or to protect the rights, property, and safety of others, we may share your information as permitted or required by any applicable law, rule, or regulation. This includes exchanging information with other entities for fraud protection and credit risk reduction.</p>

                            <h5>Business Transfers</h5>
                            <p>We may share or transfer your information in connection with, or during negotiations of, any merger, sale of company assets, financing, or acquisition of all or a portion of our business to another company.</p>

                            <h5>Third-Party Service Providers</h5>
                            <p>We may share your information with third parties that perform services for us or on our behalf, including payment processing, data analysis, email delivery, hosting services, customer service, and marketing assistance.</p>

                            <h5>Marketing Communications</h5>
                            <p>With your consent, or with an opportunity for you to withdraw consent, we may share your information with third parties for marketing purposes, as permitted by law.</p>

                            <h5>Interactions with Other Users</h5>
                            <p>If you interact with other users of the Site, those users may see your name, profile photo, and descriptions of your activity, including sending invitations to other users, chatting with other users, liking posts, and following blogs.</p>

                            <h5>Online Postings</h5>
                            <p>When you post comments, contributions, or other content to the Site, your posts may be viewed by all users and may be publicly distributed outside the Site in perpetuity.</p>

                            <h5>Third-Party Advertisers</h5>
                            <p>We may use third-party advertising companies to serve ads when you visit the Site. These companies may use information about your visits to the Site and other websites that are contained in web cookies to provide advertisements about goods and services of interest to you.</p>

                            <h5>Affiliates</h5>
                            <p>We may share your information with our affiliates, in which case we will require those affiliates to honor this Privacy Policy. Affiliates include our parent company and any subsidiaries, joint venture partners, or other companies that we control or that are under common control with us.</p>

                            <h5>Business Partners</h5>
                            <p>We may share your information with our business partners to offer you certain products, services, or promotions.</p>

                            <h4>4. Security of Your Information</h4>
                            <p>We use administrative, technical, and physical security measures to help protect your personal information. While we have taken reasonable steps to secure the personal information you provide to us, please be aware that despite our efforts, no security measures are perfect or impenetrable, and no method of data transmission can be guaranteed against any interception or other type of misuse.</p>

                            <h4>5. Policy for Children</h4>
                            <p>We do not knowingly solicit information from or market to children under the age of 13. If we learn that we have collected personal information from a child under age 13 without verification of parental consent, we will delete that information as quickly as possible. If you become aware of any data we have collected from children under age 13, please contact us at [Contact Information].</p>

                            <h4>6. Controls for Do-Not-Track Features</h4>
                            <p>Most web browsers and some mobile operating systems include a Do-Not-Track ("DNT") feature or setting you can activate to signal your privacy preference not to have data about your online browsing activities monitored and collected. No uniform technology standard for recognizing and implementing DNT signals has been finalized. As such, we do not currently respond to DNT browser signals or any other mechanism that automatically communicates your choice not to be tracked online. If a standard for online tracking is adopted that we must follow in the future, we will inform you about that practice in a revised version of this Privacy Policy.</p>

                            <h4>7. Options Regarding Your Information</h4>
                            <p>You may at any time review or change the information in your account or terminate your account by:</p>
                            <ul>
                                <li class="list-item">Logging into your account settings and updating your account.</li>
                                <li class="list-item">Contacting us using the contact information provided below.</li>
                            </ul>
                            <p>Upon your request to terminate your account, we will deactivate or delete your account and information from our active databases. However, some information may be retained in our files to prevent fraud, troubleshoot problems, assist with any investigations, enforce our Terms of Use, and/or comply with legal requirements.</p>

                            <h4>8. Contact Us</h4>
                            <p>If you have questions or comments about this Privacy Policy, please contact us at:</p>
                            <p>Email: {{$web->email}}</p>
                            <p>Phone: {{$web->phone}}</p>
                            <p>Address: {!! $web->address !!}</p>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection
