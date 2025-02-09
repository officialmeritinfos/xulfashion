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
                                Last Updated: 03, February, 2025
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
                    <h3 class="job_title">{{ $pageName }}</h3>
                    <p><strong>Effective Date:</strong> 03/02/2025</p>
                    <p><strong>Entity Name:</strong> {{$siteName}} by XulTech Ltd</p>
                    <p><strong>Contact Email:</strong> {{$web->supportEmail}}</p>

                    <h2 class="mt-4">1. Introduction</h2>
                    <p>
                        This Ad Posting Policy governs the submission, review, approval, and display of advertisements ("ads") by merchants on the Xulfashion platform.
                        By submitting an ad, merchants agree to comply with the terms set forth in this policy. Xulfashion reserves the right to modify these guidelines at any time without prior notice.
                    </p>
                    <p class="fw-bold">Failure to adhere to this policy may result in ad rejection, removal, temporary suspension, or permanent loss of ad posting privileges.</p>

                    <h2 class="mt-4">2. Merchant Eligibility</h2>
                    <ul>
                        <li>Merchants must have <strong>completed their profile setup</strong>, including business name, category, and store details.</li>
                        <li>Merchants must have <strong>listed at least one product or service</strong> within their store.</li>
                        <li>Accounts must be in <strong>good standing</strong>, with no active restrictions due to policy violations.</li>
                        <li>Merchants found posting fraudulent, misleading, or inappropriate ads may be permanently restricted from ad posting.</li>
                    </ul>

                    <h2 class="mt-4">3. Ad Content Requirements</h2>

                    <h4 class="mt-3">A. Accuracy & Representation</h4>
                    <ul>
                        <li>Ads must provide an <strong>accurate and truthful representation</strong> of the product or service.</li>
                        <li>Descriptions must be <strong>clear and free from misleading claims</strong>.</li>
                        <li>The advertised product or service must be relevant to <strong>fashion, beauty, or related industries</strong>.</li>
                    </ul>

                    <h4 class="mt-3">B. Image & Media Guidelines</h4>
                    <ul>
                        <li>Ads must include <strong>high-quality images</strong> of the actual product/service.</li>
                        <li>The use of <strong>stock images or watermarked images</strong> is prohibited.</li>
                        <li>Content that is <strong>offensive, explicit, or inappropriate</strong> will be removed.</li>
                    </ul>

                    <h4 class="mt-3">C. Formatting & Language</h4>
                    <ul>
                        <li>Titles and descriptions must be <strong>grammatically correct</strong> and professionally written.</li>
                        <li>Excessive use of <strong>emojis, symbols, or all-caps text</strong> is not allowed.</li>
                        <li>Hate speech, slurs, or discriminatory remarks are strictly prohibited.</li>
                    </ul>

                    <h4 class="mt-3">D. Prohibited & Restricted Content</h4>
                    <p>The following content is strictly prohibited:</p>
                    <ul>
                        <li>Illegal, counterfeit, or restricted products</li>
                        <li>Drugs, alcohol, or controlled substances</li>
                        <li>Weapons, explosives, or dangerous items</li>
                        <li>Adult content or sexually explicit material</li>
                        <li>Ponzi schemes, multi-level marketing (MLM), or fraudulent offers</li>
                        <li>Unverified medical claims</li>
                    </ul>

                    <h2 class="mt-4">4. Ad Frequency & Posting Limitations</h2>
                    <ul>
                        <li>Each merchant is <strong>limited to 5 ad posts per day</strong>.</li>
                        <li>The same ad <strong>cannot be reposted within 72 hours</strong>.</li>
                        <li>Posting duplicate ads in different categories is prohibited.</li>
                    </ul>

                    <h2 class="mt-4">5. Ad Review & Approval Process</h2>

                    <h4 class="mt-3">A. Review & Approval Timeline</h4>
                    <p>All ads undergo a <strong>mandatory review process</strong>. Approval may take a few hours depending on volume.</p>

                    <h4 class="mt-3">B. Rejection & Resubmission</h4>
                    <p>Ads may be rejected for:</p>
                    <ul>
                        <li>Low-quality or misleading images</li>
                        <li>False claims or deceptive descriptions</li>
                        <li>Duplicate posting within 72 hours</li>
                        <li>Incorrect category placement</li>
                    </ul>
                    <p>Merchants will receive a notification detailing the reason for rejection and may resubmit a corrected version.</p>

                    <h4 class="mt-3">C. Appeals Process</h4>
                    <p>Merchants may appeal rejected ads through Xulfashion Customer Support.</p>

                    <h2 class="mt-4">6. Featured & Boosted Ads</h2>
                    <ul>
                        <li>Xulfashion may select high-quality ads for featured placement.</li>
                        <li>Merchants may request paid featured placements.</li>
                        <li>Selected ads may be promoted on external platforms such as social media.</li>
                    </ul>

                    <h2 class="mt-4">7. Violations & Enforcement Actions</h2>

                    <h4 class="mt-3">A. Progressive Disciplinary Measures</h4>
                    <ul>
                        <li><strong>First Violation:</strong> Ad rejection with a warning.</li>
                        <li><strong>Second Violation:</strong> Temporary ad posting restriction.</li>
                        <li><strong>Third Violation:</strong> Permanent ad posting suspension.</li>
                    </ul>

                    <h4 class="mt-3">B. Severe Violations</h4>
                    <ul>
                        <li>Serious violations may result in immediate removal of ads.</li>
                        <li>Repeated policy breaches may lead to account suspension or termination.</li>
                    </ul>

                    <h2 class="mt-4">8. Amendments & Updates</h2>
                    <p>Xulfashion reserves the right to modify this policy at any time. Merchants are responsible for reviewing updates regularly.</p>

                    <h3 class="mt-5 text-center">Need Help?</h3>
                    <p class="text-center">For inquiries or support, please contact <a href="{{ route('home.contact') }}">Xulfashion Customer Support</a>.</p>

                </section>


            </div>
        </div>
    </section>


@endsection
