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
                            <h5>{{$pageName}}</h5>
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
                            <p>Welcome to {{$siteName}}! These terms of service outline the rules and regulations for the use of {{$siteName}}'s website and services. By accessing this website and using our services, you accept these terms and conditions in full. Do not continue to use {{$siteName}}'s website or services if you do not accept all of the terms and conditions stated on this page.</p>

                            <h5>1. Introduction</h5>
                            <p>These terms and conditions govern your use of this website and any services provided by {{$siteName}}. By using our website, you agree to these terms and conditions in full. If you disagree with these terms and conditions or any part of these terms and conditions, you must not use our website.</p>

                            <h5>2. Eligibility</h5>
                            <p>By using our website and services, you represent and warrant that you are at least 18 years old or the legal age of majority in your jurisdiction. If you are under 18 or the applicable age of majority, you may only use our services under the supervision of a parent or legal guardian who agrees to be bound by these terms and conditions.</p>

                            <h5>3. Account Registration</h5>
                            <p>To access certain features of our website and services, you may be required to register for an account. You agree to provide accurate, current, and complete information during the registration process and to update such information to keep it accurate, current, and complete. You are responsible for safeguarding your password and other login credentials, and you agree not to disclose them to any third party. You must notify us immediately if you suspect any unauthorized use of your account.</p>

                            <h5>4. User Responsibilities</h5>
                            <p>As a user of {{$siteName}}, you agree to comply with all applicable laws and regulations, and you agree not to:</p>
                            <ul>
                                <li class="list-item">Use our website or services for any unlawful purpose.</li>
                                <li class="list-item">Engage in any conduct that restricts or inhibits any other user from using or enjoying our website or services.</li>
                                <li class="list-item">Impersonate any person or entity or falsely state or otherwise misrepresent your affiliation with a person or entity.</li>
                                <li class="list-item">Upload, post, or transmit any content that you do not have a right to transmit under any law or under contractual or fiduciary relationships.</li>
                                <li class="list-item">Upload, post, or transmit any material that contains software viruses or any other computer code, files, or programs designed to interrupt, destroy, or limit the functionality of any computer software or hardware.</li>
                            </ul>

                            <h5>5. Content and Intellectual Property</h5>
                            <p>All content included on this website, such as text, graphics, logos, images, and software, is the property of {{$siteName}} or its content suppliers and protected by international copyright laws. The compilation of all content on this website is the exclusive property of {{$siteName}}, with copyright authorship for this collection by {{$siteName}}, and protected by international copyright laws.</p>
                            <p>You may not modify, copy, distribute, transmit, display, perform, reproduce, publish, license, create derivative works from, transfer, or sell any information, software, products, or services obtained from this website without prior written consent from {{$siteName}}.</p>

                            <h5>6. User-Generated Content</h5>
                            <p>By submitting content to {{$siteName}} (including but not limited to images, designs, text, and other material), you grant {{$siteName}} a non-exclusive, royalty-free, worldwide, perpetual, and irrevocable right to use, reproduce, modify, adapt, publish, translate, distribute, perform, and display such content in any media. You also grant {{$siteName}} the right to sublicense these rights to others.</p>
                            <p>You represent and warrant that you own or otherwise control all of the rights to the content that you submit; that the content is accurate; that use of the content you supply does not violate these terms and conditions and will not cause injury to any person or entity; and that you will indemnify {{$siteName}} for all claims resulting from content you supply.</p>

                            <h5>7. Termination</h5>
                            <p>We may terminate or suspend your account and bar access to the Service immediately, without prior notice or liability,
                                under our sole discretion, for any reason whatsoever and without limitation, mostly for but not limited to a breach of the Terms, Court Order etc.
                                If you wish to terminate your account, you may simply discontinue using the Service.</p>

                            <h5>8. Disclaimer of Warranties</h5>
                            <p>The services are provided "as is" and "as available" without any warranties of any kind, either express or implied, including, but not limited to, implied warranties of merchantability, fitness for a particular purpose, non-infringement, or course of performance.</p>

                            <h5>9. Limitation of Liability</h5>
                            <p>In no event shall {{$siteName}}, nor its directors, employees, partners, agents, suppliers, or affiliates, be liable for any indirect, incidental, special, consequential, or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from (i) your access to or use of or inability to access or use the service; (ii) any conduct or content of any third party on the service; (iii) any content obtained from the service; and (iv) unauthorized access, use, or alteration of your transmissions or content, whether based on warranty, contract, tort (including negligence), or any other legal theory, whether or not we have been informed of the possibility of such damage.</p>

                            <h5>10. Governing Law</h5>
                            <p>These terms shall be governed and construed in accordance with the laws of the base of {{$siteName}}, without regard to its conflict of law provisions. Our failure to enforce any right or provision of these terms will not be considered a waiver of those rights. If any provision of these terms is held to be invalid or unenforceable by a court, the remaining provisions of these terms will remain in effect. These terms constitute the entire agreement between us regarding our service, and supersede and replace any prior agreements we might have between us regarding the service.</p>

                            <h5>11. Changes to Terms</h5>
                            <p>We reserve the right, at our sole discretion, to modify or replace these terms at any time. If a revision is material, we will provide at least 30 days' notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion. By continuing to access or use our service after any revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, you are no longer authorized to use the service.</p>
                            <h5>12. Contact Us</h5>
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
