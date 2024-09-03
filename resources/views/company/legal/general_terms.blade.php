@extends('company.layouts.base')
@section('content')

    <section class="blog_single_breadcrumb_area dark_bg" data-bg-color="#FFF8FD">
        <ul class="list-unstyled testimonial_bg_shap job_b_shap">
            <li data-parallax='{"x": 0, "y": -100}'><img src="{{asset('home/main/img/home-three/round.png')}}" alt=""></li>
        </ul>
        <div class="container">
            <div class="breadcrumb_content text-center">
                <h1 class="blog_title_big">{{$pageName}}</h1>
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

                <section id="about-us">
                    <h3 class="job_title">1. About Us</h3>
                    <p>
                        {{$siteName}} is a specialized online platform dedicated to connecting fashion creators and shoppers globally. We offer a marketplace where designers, tailors, models, and retailers can showcase their unique creations to a wider audience, empowering the fashion industry with tools that foster creativity and growth.
                    </p>
                </section>

                <section id="relationship">
                    <h3 class="job_title">2. Relationship</h3>
                    <p>
                        By accessing and using {{$siteName}}, you agree to be bound by these Terms & Conditions. These terms form a legal agreement between you (the user) and {{$siteName}}. Your continued use of the platform signifies your acceptance of these terms. If you do not agree with any part of these terms, you must discontinue use of the platform immediately.
                    </p>
                </section>

                <section id="privacy-policy">
                    <h3 class="job_title">3. Privacy Policy</h3>
                    <p>
                        Your privacy is important to us. Our Privacy Policy outlines how we collect, use, and protect your personal information. By using {{$siteName}}, you consent to our data practices as described in the Privacy Policy. We encourage you to review our Privacy Policy regularly to stay informed about how we are protecting your information.
                    </p>
                </section>

                <section id="copyright">
                    <h3 class="job_title">4. Copyright</h3>
                    <p>
                        All content on {{$siteName}}, including text, graphics, logos, images, and software, is the property of {{$siteName}} or its content suppliers and is protected by international copyright laws. You may not reproduce, distribute, or create derivative works from any content on {{$siteName}} without our explicit permission.
                    </p>
                </section>

                <section id="your-content">
                    <h3 class="job_title">5. Your Content</h3>
                    <p>
                        By uploading or posting content on {{$siteName}}, you grant us a non-exclusive, worldwide, royalty-free license to use, reproduce, modify, and display your content. You retain ownership of your content but agree to allow us to use it in connection with the operation and promotion of the platform.
                    </p>
                </section>

                <section id="restrictions">
                    <h3 class="job_title">6. Restrictions on Our Website</h3>
                    <p>
                        You are prohibited from using {{$siteName}} for any unlawful purpose or in a way that violates these Terms & Conditions. This includes, but is not limited to, infringing on the rights of others, posting harmful or malicious content, and using the platform for spamming or phishing activities.
                    </p>
                </section>

                <section id="age-restriction">
                    <h3 class="job_title">7. Age Restriction</h3>
                    <p>
                        Users must be at least 13 years of age to use {{$siteName}}. However, some services and features may require users to be 18 years or older. By using the platform, you confirm that you meet the applicable age requirements.
                    </p>
                </section>

                <section id="transaction-fees">
                    <h3 class="job_title">8. Transaction Fees</h3>
                    <p>
                        {{$siteName}} charges a transaction fee on each purchase made through our website. This fee is deducted from the total amount paid by the buyer at the time of purchase. By using {{$siteName}}, you agree to this fee structure. We reserve the right to modify the fee structure at any time, with notice provided to users in accordance with these Terms & Conditions.
                    </p>
                </section>

                <section id="acceptable-use-policy">
                    <h3 class="job_title">9. Acceptable Use Policy</h3>
                    <p>
                        You agree to use {{$siteName}} in a manner that is lawful and in accordance with these Terms & Conditions. Prohibited activities include, but are not limited to, fraudulent activities, impersonation, harassment, and any action that could harm the reputation of {{$siteName}} or its users.
                    </p>
                </section>

                <section id="disclaimer">
                    <h3 class="job_title">10. Disclaimer</h3>
                    <p>
                        {{$siteName}} provides the platform on an "as is" basis without warranties of any kind, either express or implied. We do not guarantee that the platform will be error-free, uninterrupted, or secure. Your use of the platform is at your own risk.
                    </p>
                </section>

                <section id="limitation-of-liability">
                    <h3 class="job_title">11. Limitation of Liability</h3>
                    <p>
                        To the fullest extent permitted by law, {{$siteName}} shall not be liable for any indirect, incidental, special, or consequential damages arising out of or in connection with your use of the platform, even if we have been advised of the possibility of such damages.
                    </p>
                </section>

                <section id="exclusions">
                    <h3 class="job_title">12. Exclusions</h3>
                    <p>
                        Certain jurisdictions do not allow the exclusion of certain warranties or the limitation of liability for consequential or incidental damages. Therefore, the above limitations may not apply to you.
                    </p>
                </section>

                <section id="indemnification">
                    <h3 class="job_title">13. Indemnification</h3>
                    <p>
                        You agree to indemnify and hold harmless {{$siteName}}, its officers, directors, employees, and agents from any claims, damages, liabilities, and expenses (including reasonable attorneys' fees) arising out of or related to your use of the platform, your violation of these Terms & Conditions, or your infringement of any third-party rights.
                    </p>
                </section>

                <section id="termination">
                    <h3 class="job_title">14. Termination</h3>
                    <p>
                        {{$siteName}} reserves the right to terminate or suspend your access to the platform at any time, with or without notice, for any violation of these Terms & Conditions or for any other reason at our sole discretion.
                    </p>
                </section>

                <section id="links-to-other-websites">
                    <h3 class="job_title">15. Links to Other Websites</h3>
                    <p>
                        {{$siteName}} may contain links to third-party websites. We do not control or endorse these websites and are not responsible for their content or privacy practices. Your use of third-party websites is at your own risk.
                    </p>
                </section>

                <section id="our-role">
                    <h3 class="job_title">16. Our Role</h3>
                    <p>
                        (a) We do not confirm the identity of all Website or Services users, check their creditworthiness or bona fides, or otherwise vet them.
                        <br>
                        (b) We are not a party to any contract for the sale or purchase of products.
                        <br>
                        (c) We are not involved in any transaction between a buyer and a seller in any way.
                        <br>
                        (d) We are not the agents for any buyer or seller and accordingly, we will not be liable to any person in relation to an offer for sale, sale, purchase, payment for, or delivery of any products.
                        <br>
                        (e) We are not responsible for the enforcement of any contractual obligations arising out of a contract for the sale or purchase of any goods or products and we will have no obligation to mediate between the parties to any such contract.
                    </p>
                    <p>
                        15.2 We do not warrant or represent:
                        <br>
                        (a) The completeness or accuracy of the information published on our Website or the Services.
                        <br>
                        (b) That the material on the Website or the Services is up to date.
                        <br>
                        (c) That the Website will operate without fault.
                        <br>
                        (d) That the Website or any product or service on the Website or the Services will remain available.
                    </p>
                    <p>
                        15.3 We reserve the right to discontinue or alter any or all of our Services, and to stop publishing our Website, at any time in our sole discretion without notice or explanation. We do not guarantee any commercial results concerning the use of the Website or Services. To the maximum extent permitted by applicable law, we exclude all representations and warranties relating to the subject matter of these Terms, our Website, and the use of our Website and Services.
                    </p>
                </section>

                <section id="updates">
                    <h3 class="job_title">17. Updates, Modifications & Amendments</h3>
                    <p>
                        {{$siteName}} reserves the right to update, modify, or amend these Terms & Conditions at any time. Any changes will be posted on this page, and the effective date will be updated accordingly. It is your responsibility to review these terms regularly to stay informed of any changes.
                    </p>
                </section>



                <section id="applicable-laws">
                    <h3 class="job_title">18. Applicable Laws</h3>
                    <p>
                        These Terms & Conditions shall be governed by and construed in accordance with the laws of the jurisdiction in which XulfIt seems that my response was cut off. Let's continue and complete the Terms and Conditions content:

                        These Terms & Conditions shall be governed by and construed in accordance with the laws of the jurisdiction in which {{$siteName}} operates. Any disputes arising under or in connection with these terms shall be subject to the exclusive jurisdiction of the courts in that jurisdiction.
                    </p>
                </section>

                <section id="legal-disputes">
                    <h3 class="job_title">19. Legal Disputes</h3>
                    <p>
                        In the event of any legal disputes related to your use of {{$siteName}}, you agree to first contact us to attempt to resolve the dispute informally. If we are unable to resolve the dispute within a reasonable time, you agree to submit the dispute to binding arbitration or to the jurisdiction of the courts, as determined by {{$siteName}}.
                    </p>
                </section>

                <section id="severability">
                    <h3 class="job_title">20. Severability</h3>
                    <p>
                        If any provision of these Terms & Conditions is found to be invalid or unenforceable by a court of competent jurisdiction, the remaining provisions will remain in full force and effect. The invalid or unenforceable provision will be severed from the agreement, with the remaining terms interpreted to fulfill the original intent as closely as possible.
                    </p>
                </section>

                <section id="miscellaneous">
                    <h3 class="job_title">21. Miscellaneous</h3>
                    <p>
                        These Terms & Conditions, together with our Privacy Policy and any other legal notices published by us on {{$siteName}}, shall constitute the entire agreement between you and {{$siteName}} concerning your use of the platform. Our failure to exercise or enforce any right or provision of these terms shall not constitute a waiver of such right or provision.
                    </p>
                </section>

                <section id="contact-us">
                    <h3 class="job_title">22. Contact Us</h3>
                    <p>
                        If you have any questions or concerns regarding these Terms & Conditions or your use of {{$siteName}}, please contact us at
                        {{$web->email}}. We are committed to addressing your inquiries and will respond as quickly as possible.
                    </p>
                </section>

            </div>
        </div>
    </section>


@endsection
