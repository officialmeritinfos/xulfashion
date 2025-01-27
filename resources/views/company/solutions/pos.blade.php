@extends('company.layout.base')
@section('content')

   <!-- =============================================
    Hero Banner
    ==============================================
    -->
    <div class="hero-banner-three z-1 position-relative pt-200 lg-pt-150">
        <div class="container position-relative">
            <div class="row">
                <div class="col-xl-10 col-lg-10 m-auto text-center">
                    <h1 class="hero-heading wow fadeInUp">Streamline Your Sales with Effortless POS Integration</h1>
                    <p class="fs-28 text-dark pt-40 lg-pt-30 pb-35 lg-pb-20 wow fadeInUp" data-wow-delay="0.1s">
                        Take your in-store checkout to the next level with {{$siteName}}'s Point-of-Sale solution. Experience
                        seamless transactions, instant inventory updates, and an intuitive interface tailored for your fashion business.
                    </p>
                    <form action="" class="m-auto position-relative">
                        <a href="{{ route('home.download') }}" class="tran3s btn-eighteen">Join Now!</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="media d-flex justify-content-center mt-100 lg-mt-60">
            <div class="position-relative">
                <img src="{{asset('home/mobile/images/pointofsale.png')}}" alt="" >
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_29.png')}}" alt="" class="shapes shape_01">
        <img src="{{asset('home/mobile/images/shape/shape_30.png')}}" alt="" class="shapes shape_02">
    </div>
    <!-- /.hero-banner-three -->


  <!-- =====================================================
   BLock Feature Nine
   =====================================================
   -->
   <div class="block-feature-nine pt-180 xl-pt-150 lg-pt-80">
       <div class="container">
           <div class="row align-items-center">
               <div class="col-xl-5 col-lg-6 order-lg-last">
                   <div class="ps-xl-5 ms-xxl-3">
                       <div class="title-four">
                           <h2>Fast and Easy Checkout</h2>
                       </div>
                       <p class="fs-24 font-manrope mt-45 lg-mt-30 mb-45 lg-mb-30">
                           Optimize your in-store sales with {{$siteName}}'s Point-of-Sale system. Enable swift, hassle-free
                           transactions with an intuitive interface tailored to fashion businesses. From cash to card payments,
                           everything is seamless and secure.
                       </p>

                   </div>
               </div>
               <div class="col-xl-7 col-lg-6 col-md-10 m-auto">
                   <div class="img-holder d-flex align-items-center justify-content-center md-mt-40">
                       <img src="{{asset('home/mobile/images/fast-checkout.png')}}" alt="">
                   </div>
               </div>
           </div>
           <div class="row align-items-center mt-150 xl-mt-100 lg-mt-60">
               <div class="col-xl-5 col-lg-6 order-lg-last">
                   <div class="ps-xl-5 ms-xxl-3">
                       <div class="title-four">
                           <h2>Integrated Inventory Management</h2>
                       </div>
                       <p class="fs-24 font-manrope mt-45 lg-mt-30 mb-45 lg-mb-30">
                           Keep your inventory updated in real-time with every sale made. {{$siteName}}’s POS solution automatically
                           syncs with your inventory, ensuring accurate records and eliminating stock errors.
                       </p>
                   </div>
               </div>
               <div class="col-xl-7 col-lg-6 col-md-10 m-auto">
                   <div class="img-holder d-flex align-items-center justify-content-center md-mt-40">
                       <img src="{{asset('home/mobile/images/integrated-inventory.png')}}" alt="">
                   </div>
               </div>
           </div>
           <div class="row align-items-center mt-150 xl-mt-100 lg-mt-60">
               <div class="col-xl-5 col-lg-6 order-lg-last">
                   <div class="ps-xl-5 ms-xxl-3">
                       <div class="title-four">
                           <h2>Detailed Sales Reporting</h2>
                       </div>
                       <p class="fs-24 font-manrope mt-45 lg-mt-30 mb-45 lg-mb-30">
                           Understand your business better with powerful analytics. Generate detailed reports on sales,
                           inventory, and staff performance to make informed decisions and grow your business effortlessly.
                       </p>
                   </div>
               </div>
               <div class="col-xl-7 col-lg-6 col-md-10 m-auto">
                   <div class="img-holder d-flex align-items-center justify-content-center md-mt-40">
                       <img src="{{asset('home/mobile/images/sales-report.png')}}" alt="">
                   </div>
               </div>
           </div>
       </div>
   </div>
   <!-- /.block-feature-nine -->


   <!--
   =====================================================
       Block Feature Ten
   =====================================================
   -->
   <div class="block-feature-ten position-relative z-2 pt-150 lg-pt-80">
       <div class="container">
           <div class="row">
               <div class="col-xl-7 col-lg-8 m-auto">
                   <div class="title-four text-center mb-35 lg-mb-30">
                       <h2>What Makes Our Point-of-Sale Solution Unique?</h2>
                   </div>
               </div>
           </div>
           <p class="fs-24 text-dark text-center font-manrope pb-70 lg-pb-40">The {{$siteName}} Point-of-Sale system stands out for its seamless integration, tailored features, and business-enhancing tools designed specifically for fashion businesses.</p>

           <div class="row justify-content-between">
               <div class="col-xxl-3 col-lg-4">
                   <div class="card-style-five text-center mb-25">
                       <div class="icon d-flex align-items-center justify-content-center rounded-circle">
                           <img src="{{asset('home/mobile/images/icon/icon_21.svg')}}" alt="Ease of Use">
                       </div>
                       <span>Seamless Checkout</span>
                       <p class="font-manrope fw-600 lh-base fs-24 text-dark">Fast, hassle-free <br> in-store checkout experience.</p>
                   </div>
                   <!-- /.card-style-five -->
               </div>
               <div class="col-xxl-3 col-lg-4">
                   <div class="card-style-five text-center mb-25">
                       <div class="icon d-flex align-items-center justify-content-center rounded-circle">
                           <img src="{{asset('home/mobile/images/icon/icon_22.svg')}}" alt="Integration">
                       </div>
                       <span>Real-Time Inventory Sync</span>
                       <p class="font-manrope fw-600 lh-base fs-24 text-dark">Automatic updates <br> to inventory after every sale.</p>
                   </div>
                   <!-- /.card-style-five -->
               </div>
               <div class="col-xxl-3 col-lg-4">
                   <div class="card-style-five text-center mb-25">
                       <div class="icon d-flex align-items-center justify-content-center rounded-circle">
                           <img src="{{asset('home/mobile/images/icon/icon_23.svg')}}" alt="Data Insights">
                       </div>
                       <span>Sales Analytics</span>
                       <p class="font-manrope fw-600 lh-base fs-24 text-dark">Detailed reports <br> to track performance and trends.</p>
                   </div>
                   <!-- /.card-style-five -->
               </div>
           </div>
       </div>
   </div>
   <!-- /.block-feature-ten -->




   <!--
       =====================================================
           FAQ Section Three
       =====================================================
       -->
   <div class="faq-section-three position-relative mt-150 xl-mt-120 lg-mt-80">
       <div class="container">
           <div class="title-six text-center mb-80 lg-mb-40">
               <h2>Questions & Answers</h2>
           </div>

           <div class="row">
               <div class="col-lg-10 m-auto">
                   <div class="accordion accordion-style-two p0 shadow-none ms-xxl-4 me-xxl-4" id="accordionFour">
                       <div class="accordion-item">
                           <h2 class="accordion-header">
                               <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneA" aria-expanded="false" aria-controls="collapseOneA">
                                   What is the {{$siteName}} Point-of-Sale Solution?
                               </button>
                           </h2>
                           <div id="collapseOneA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                               <div class="accordion-body">
                                   <p class="fs-22">The {{$siteName}} Point-of-Sale (POS) solution is a powerful tool designed for fashion businesses to enable seamless in-store transactions, simplify checkout processes, and integrate directly with the inventory system for real-time updates.</p>
                               </div>
                           </div>
                       </div>
                       <div class="accordion-item">
                           <h2 class="accordion-header">
                               <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoA" aria-expanded="false" aria-controls="collapseTwoA">
                                   How does the POS system integrate with inventory management?
                               </button>
                           </h2>
                           <div id="collapseTwoA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                               <div class="accordion-body">
                                   <p class="fs-22">Our POS system automatically updates your inventory records in real time after each transaction. This ensures that your stock levels are always accurate, reducing errors and streamlining your business operations.</p>
                               </div>
                           </div>
                       </div>
                       <div class="accordion-item">
                           <h2 class="accordion-header">
                               <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeA" aria-expanded="true" aria-controls="collapseThreeA">
                                   Can the POS system handle multiple payment methods?
                               </button>
                           </h2>
                           <div id="collapseThreeA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                               <div class="accordion-body">
                                   <p class="fs-22">Yes! The {{$siteName}} POS solution supports various payment methods including cash, credit/debit cards, and digital wallets, ensuring a smooth checkout experience for your customers.</p>
                               </div>
                           </div>
                       </div>
                       <div class="accordion-item">
                           <h2 class="accordion-header">
                               <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourA" aria-expanded="true" aria-controls="collapseFourA">
                                   Is the POS solution suitable for both small and large fashion businesses?
                               </button>
                           </h2>
                           <div id="collapseFourA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                               <div class="accordion-body">
                                   <p class="fs-22">Absolutely! Whether you run a boutique or a large fashion chain, our POS solution is scalable and can be customized to meet the unique needs of your business.</p>
                               </div>
                           </div>
                       </div>
                       <div class="accordion-item">
                           <h2 class="accordion-header">
                               <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiveA" aria-expanded="true" aria-controls="collapseFiveA">
                                   Does the POS system provide sales reporting?
                               </button>
                           </h2>
                           <div id="collapseFiveA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                               <div class="accordion-body">
                                   <p class="fs-22">Yes, the {{$siteName}} POS solution generates detailed sales reports to help you track performance, identify trends, and make data-driven decisions for your fashion business.</p>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <!-- /.faq-section-three -->

   <!--
       =====================================================
           Fancy Banner Three
       =====================================================
       -->
   <div class="fancy-banner-three pt-150 lg-pt-80 pb-150 lg-pb-80 position-relative z-1">
       <div class="container">
           <img src="{{asset($web->logo)}}" alt="" class="m-auto" style="width: 150px;">
           <div class="row">
               <div class="col-xl-8 m-auto text-center">
                   <h2 class="mt-30 mb-40 lg-mb-30">Unlock the power of {{$siteName}} Try it now!</h2>
                   <p class="fs-28 mb-50 lg-mb-30">Try it for free free</p>
                   <a href="{{route('mobile.register')}}" class="btn-eleven">Try it Now!</a>
               </div>
           </div>
       </div>
       <img src="{{asset('home/mobile/images/shape/shape_39.svg')}}" alt="" class="shapes shape_01">
       <img src="{{asset('home/mobile/images/shape/shape_40.svg')}}" alt="" class="shapes shape_02">
   </div>


@endsection
