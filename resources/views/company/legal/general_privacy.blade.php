@extends('company.layouts.base')
@section('content')

    <section class="blog_single_breadcrumb_area dark_bg" data-bg-color="#FFF8FD">
        <ul class="list-unstyled testimonial_bg_shap job_b_shap">
            <li data-parallax='{"x": 0, "y": -100}'><img src="{{asset('home/main/img/home-three/round.png')}}" alt=""></li>
        </ul>
        <div class="container">
            <div class="breadcrumb_content text-center">
                <h1 class="blog_title_big">{{$pageName}}</h3>
                <ul class="job_meta pt-3">
                    <li><a href="#"><img class="icon" src="{{asset('home/main/img/career/svg/house.svg')}}" alt="">
                            Last Updated: 03, September, 2024
                        </a></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="job_details_area blog_section_top">
        <ul class="list-unstyled features_bg_shap">
            <li data-parallax='{"x": 0, "y": 100}'><img src="{{asset('home/main/img/career/circle_gradient.png')}}" alt=""></li>
            <li data-parallax='{"x": 0, "y": -100}'><img src="{{asset('home/main/img/blog/dot.png')}}" alt=""></li>
        </ul>
        <div class="container">
            <div class="job_details_content">

                <section id="privacy-policy">
                    <h3 class="job_title">Privacy Policy</h3>
                    <p>
                        Xulfashion ("we," "our," "us") is committed to protecting the privacy and security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website, use our services, or interact with our platform in any way. By using Xulfashion, you consent to the practices described in this policy.
                    </p>

                    <h2>1. Information We Collect</h2>
                    <p>
                        We collect various types of information to provide and improve our services. This includes:
                    </p>
                    <ul>
                        <li><strong>Personal Information:</strong> Information that can identify you, such as your name, email address, phone number, and payment details.</li>
                        <li><strong>Non-Personal Information:</strong> Data that cannot be used to identify you, including browsing history, device information, and aggregated user statistics.</li>
                        <li><strong>Transaction Information:</strong> Details about your purchases, including product descriptions, payment amounts, and transaction dates.</li>
                    </ul>

                    <h2>2. How We Use Your Information</h2>
                    <p>
                        We use the information we collect for various purposes, including:
                    </p>
                    <ul>
                        <li><strong>To Provide Services:</strong> Processing transactions, managing your account, and delivering customer support.</li>
                        <li><strong>To Improve Our Platform:</strong> Analyzing user behavior, troubleshooting issues, and enhancing user experience.</li>
                        <li><strong>For Marketing:</strong> Sending promotional messages, newsletters, and offers that may interest you.</li>
                        <li><strong>To Comply with Legal Obligations:</strong> Ensuring compliance with applicable laws, regulations, and legal processes.</li>
                    </ul>

                    <h2>3. Sharing Your Information</h2>
                    <p>
                        We may share your information with third parties in the following circumstances:
                    </p>
                    <ul>
                        <li><strong>With Service Providers:</strong> Partners who assist in providing our services, such as payment processors, hosting providers, and customer support teams.</li>
                        <li><strong>For Legal Reasons:</strong> When required by law or to protect our rights, property, or the safety of our users.</li>
                        <li><strong>With Your Consent:</strong> If you give us permission to share your information for specific purposes.</li>
                    </ul>

                    <h2>4. Cookies and Tracking Technologies</h2>
                    <p>
                        We use cookies and similar technologies to enhance your experience on our platform. Cookies help us understand user behavior, customize content, and remember your preferences. You can control the use of cookies through your browser settings, but disabling cookies may affect your ability to use certain features of the platform.
                    </p>

                    <h2>5. Data Security</h2>
                    <p>
                        We take data security seriously and implement appropriate measures to protect your personal information. However, no method of transmission over the internet or electronic storage is 100% secure. While we strive to protect your data, we cannot guarantee its absolute security.
                    </p>

                    <h2>6. Your Rights</h2>
                    <p>
                        You have the right to access, correct, or delete your personal information at any time. You can update your information through your account settings or by contacting us directly. You also have the right to object to the processing of your data or request restrictions on its use.
                    </p>

                    <h2>7. Account Deletion</h2>
                    <p>
                        If you wish to delete your account, you can request this by <a href="{{route('home.delete-my-information')}}">Here</a> .
                        Account deletion requests are processed within 30 days, provided no cancellation is received.
                        Once your account is deleted, your data will be permanently removed from our systems, except where retention is required by law.
                    </p>

                    <h2>8. Children’s Privacy</h2>
                    <p>
                        Xulfashion is not intended for users under the age of 13. We do not knowingly collect personal information from children under 13. If we become aware that we have collected such information, we will take steps to delete it promptly.
                    </p>

                    <h2>9. International Data Transfers</h2>
                    <p>
                        Your information may be transferred to, and maintained on, servers located outside of your state, province, country, or other governmental jurisdiction where the data protection laws may differ. By using our services, you consent to such transfers.
                    </p>

                    <h2>10. Changes to This Privacy Policy</h2>
                    <p>
                        We may update this Privacy Policy from time to time to reflect changes in our practices or legal requirements. We will notify you of any significant changes by posting the new policy on our website and updating the effective date. We encourage you to review this policy periodically.
                    </p>

                    <h2>11. Contact Us</h2>
                    <p>
                        If you have any questions or concerns about this Privacy Policy or our data practices, please contact us at {{$web->email}}.
                    </p>
                </section>


            </div>
        </div>
    </section>


@endsection
