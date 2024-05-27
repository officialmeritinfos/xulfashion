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
                            <p>At {{$siteName}}, we are committed to the highest standards of anti-money laundering (AML) compliance and counter-terrorism financing (CTF). This policy outlines our approach to preventing and mitigating the risks of money laundering and terrorist financing activities. Our aim is to protect our platform from being used for illegal financial activities.</p>

                            <h5>1. Purpose</h5>
                            <p>The purpose of this AML policy is to ensure that {{$siteName}} complies with all applicable laws and regulations aimed at combating money laundering and terrorism financing. This policy provides a framework for detecting, preventing, and reporting suspicious activities.</p>

                            <h5>2. Scope</h5>
                            <p>This policy applies to all employees, officers, and agents of {{$siteName}}, including any third parties that have contractual agreements with {{$siteName}}. It covers all aspects of our operations and services.</p>

                            <h5>3. AML Compliance Officer</h5>
                            <p>{{$siteName}} has appointed an AML Compliance Officer who is responsible for implementing and overseeing our AML program. The AML Compliance Officer's duties include:</p>
                            <ul>
                                <li class="list-item">Developing and maintaining the AML program.</li>
                                <li class="list-item">Monitoring compliance with AML regulations and internal policies.</li>
                                <li class="list-item">Conducting regular risk assessments.</li>
                                <li class="list-item">Providing ongoing AML training to employees.</li>
                                <li class="list-item">Reporting suspicious activities to the relevant authorities.</li>
                            </ul>

                            <h5>4. Customer Due Diligence (CDD)</h5>
                            <p>{{$siteName}} implements a comprehensive Customer Due Diligence (CDD) process to verify the identity of our customers. The CDD process includes:</p>
                            <ul>
                                <li class="list-item">Identifying and verifying the identity of customers using reliable, independent source documents, data, or information.</li>
                                <li class="list-item">Identifying and verifying the identity of beneficial owners of corporate customers.</li>
                                <li class="list-item">Understanding the nature and purpose of the business relationship to develop a risk profile.</li>
                                <li class="list-item">Conducting ongoing monitoring of the business relationship to ensure that transactions are consistent with the customer’s risk profile.</li>
                            </ul>

                            <h5>5. Risk-Based Approach</h5>
                            <p>We adopt a risk-based approach to AML compliance, which involves assessing the risks of money laundering and terrorist financing and implementing appropriate measures to mitigate those risks. This approach includes:</p>
                            <ul>
                                <li class="list-item">Assessing the risk of money laundering and terrorist financing based on the customer profile, geographical location, and nature of transactions.</li>
                                <li class="list-item">Implementing enhanced due diligence for high-risk customers and transactions.</li>
                                <li class="list-item">Regularly reviewing and updating risk assessments to reflect changes in the business environment and regulatory landscape.</li>
                            </ul>

                            <h5>6. Record Keeping</h5>
                            <p>{{$siteName}} maintains accurate records of all transactions and customer information for a minimum period of five years, or as required by applicable laws and regulations. These records include:</p>
                            <ul>
                                <li class="list-item">Customer identification and verification documents.</li>
                                <li class="list-item">Transaction records.</li>
                                <li class="list-item">Correspondence and communications with customers.</li>
                                <li class="list-item">Reports of suspicious activities.</li>
                            </ul>

                            <h5>7. Reporting Suspicious Activities</h5>
                            <p>All employees are required to report any suspicious activities to the AML Compliance Officer immediately. The AML Compliance Officer will investigate and, if necessary, report the suspicious activity to the relevant authorities. Examples of suspicious activities include:</p>
                            <ul>
                                <li class="list-item">Transactions that are inconsistent with the customer’s known business or personal activities.</li>
                                <li class="list-item">Unusual or complex transaction patterns that have no apparent economic or lawful purpose.</li>
                                <li class="list-item">Transactions involving high-risk countries known for money laundering or terrorist financing activities.</li>
                            </ul>

                            <h5>8. Employee Training</h5>
                            <p>We provide ongoing AML training to all employees to ensure they understand their responsibilities under this policy and are able to identify and report suspicious activities. Training includes:</p>
                            <ul>
                                <li class="list-item">An overview of applicable AML laws and regulations.</li>
                                <li class="list-item">The AML policies and procedures of {{$siteName}}.</li>
                                <li class="list-item">How to identify and report suspicious activities.</li>
                            </ul>

                            <h5>9. Monitoring and Review</h5>
                            <p>Our AML program is subject to regular monitoring and review to ensure its effectiveness. This includes:</p>
                            <ul>
                                <li class="list-item">Regular audits of our AML policies and procedures.</li>
                                <li class="list-item">Updating the AML program to reflect changes in laws and regulations.</li>
                                <li class="list-item">Implementing corrective actions to address any identified deficiencies.</li>
                            </ul>

                            <h5>10. Compliance with International Standards</h5>
                            <p>{{$siteName}} is committed to complying with international AML standards, including the recommendations of the Financial Action Task Force (FATF). We work closely with regulatory authorities and industry groups to stay informed of best practices and emerging trends in AML compliance.</p>
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
