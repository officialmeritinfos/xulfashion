@extends('mobile.ads.layout.innerBase')
@section('content')

    <!-- Terms and Conditions start -->
    <section class="section-b-space mt-2">
        <div class="custom-container">
            <div class="terms-Conditions">
                <p><strong>Effective Date:</strong> 03/02/2025</p>
                <p><strong>Entity Name:</strong> {{$siteName}} by XulTech Ltd</p>
                <p><strong>Contact Email:</strong> {{$web->supportEmail}}</p>

                <p>At {{$siteName}}, we are committed to protecting your privacy. This Privacy Policy explains how we collect, use, and share your personal data when you access and use the {{$siteName}} app. By using the {{$siteName}} app, you agree to the collection and use of your information in accordance with this Privacy Policy.</p>

                <h2 class="mt-4">1. Data Collection</h2>
                <p>{{$siteName}} collects various types of data to ensure the proper functioning and improvement of our app. This data includes:</p>
                <ul>
                    <li><strong>Personal Information:</strong> Name, email address, location, phone number, and account details, which you provide when creating your account.</li>
                    <li><strong>Sensitive Information:</strong> Payment details and billing information for processing orders.</li>
                    <li><strong>Usage Data:</strong> Information on how you use the app, such as pages visited, time spent, and features used.</li>
                    <li><strong>Device Data:</strong> Information about your mobile device, if you are visiting through the web or app, including hardware model,
                        operating system, unique device identifiers, IP address, and network information.</li>
                </ul>

                <h2 class="mt-4">2. How We Use Your Data</h2>
                <p>We use the data we collect for the following purposes:</p>
                <ul>
                    <li>To provide and improve our services, ensuring seamless transactions and user experience.</li>
                    <li>To process your orders and facilitate delivery from fashion creators.</li>
                    <li>To personalize your app experience, such as showing relevant fashion products based on your preferences.</li>
                    <li>To manage your account and communicate with you regarding important updates or promotional offers.</li>
                    <li>To analyze app usage, fix bugs, and enhance performance.</li>
                </ul>

                <h2 class="mt-4">3. Sharing Your Data</h2>
                <p>{{$siteName}} does not sell or rent your personal data. However, we may share your data with:</p>
                <ul>
                    <li><strong>Service Providers:</strong> Third-party companies that assist us in processing payments, managing customer support, and performing analytics.</li>
                    <li><strong>Business Transfers:</strong> If {{$siteName}} is involved in a merger, acquisition, or asset sale, your data may be transferred.</li>
                    <li><strong>Legal Obligations:</strong> When required by law, such as responding to a legal request or protecting our legal rights.</li>
                    <li><strong>Other Users:</strong> When you engage with the {{$siteName}} community by leaving reviews, other users may see your name and feedback.</li>
                </ul>

                <h2 class="mt-4">4. Data Security</h2>
                <p>{{$siteName}} employs reasonable security measures to protect your personal information from unauthorized access, alteration, or disclosure.
                    However, no method of transmission over the internet is 100% secure. We cannot guarantee complete data security, but we are committed to
                    regularly updating our security practices to prevent unauthorized access.</p>

                <h2 class="mt-4">5. Data Retention and Deletion</h2>
                <p>We retain your personal data only for as long as necessary to fulfill the purposes outlined in this Privacy Policy. You can request the
                    deletion of your data at any time by contacting us through our privacy contact email below. Account deletion requests are processed
                    within 30 days if no cancellation is received.
                <p><a href="{{route('mobile.legal.delete-my-information')}}" class="badge bg-danger btn-sm">Request Data Deletion</a></p>
                </p>

                <h2 class="mt-4">6. Your Rights</h2>
                <p>You have the following rights regarding your data:</p>
                <ul>
                    <li><strong>Access:</strong> Request a copy of your data that we hold.</li>
                    <li><strong>Correction:</strong> Ask us to correct inaccurate or incomplete information.</li>
                    <li><strong>Deletion:</strong> Request the deletion of your data, subject to our data retention policy.</li>
                    <li><strong>Restriction:</strong> Ask us to stop processing your data under certain circumstances.</li>
                    <li><strong>Portability:</strong> Request that your data be transferred to you but not to another service provider.</li>
                </ul>

                <h2 class="mt-4">7. Children’s Privacy</h2>
                <p>Our app is not intended for users under the age of 13. If we become aware that we have collected data from a child under 13 without
                    verification of parental consent, we will take steps to delete the information as soon as possible.</p>

                <h2 class="mt-4">8. Changes to this Privacy Policy</h2>
                <p>{{$siteName}} may update this Privacy Policy from time to time to reflect changes in our practices or legal obligations.
                    We will notify you of any material changes by updating the "Effective Date" at the top of this policy.</p>

                <h2 class="mt-4">9. Contact Us</h2>
                <p>If you have any questions or concerns about this Privacy Policy, or if you would like to exercise your rights, please contact us at:</p>
                <p><strong>{{$siteName}} Privacy Team</strong><br>Email: {{$web->supportEmail}}</p>

            </div>
        </div>
    </section>
    <!-- Terms and Conditions start -->


@endsection
