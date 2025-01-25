@extends('company.layout.base')
@section('content')

    <!--
		=====================================================
			Map Banner
		=====================================================
		-->
    <div class="map-banner-one mt-120 lg-mt-90">
        <div class="gmap_canvas h-100 w-100">
           <iframe class="gmap_iframe h-100 w-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.5777992562007!2d7.497985874992286!3d6.448214093543162!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1044a3daf432fb63%3A0xf70597895b025420!2sXultech%20LTD!5e0!3m2!1sen!2sng!4v1737771600463!5m2!1sen!2sng" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>



    <!--
    =====================================================
        Contact Section Three
    =====================================================
    -->
    <div class="contact-section-three position-relative z-1 mt-130 lg-mt-80 pb-180 lg-pb-80">
        <div class="container">

            <div class="title-two text-center mb-60 lg-mb-20 mt-150 lg-mt-80">
                <h3>Get in Touch</h3>
            </div>
            <p class="fs-24 text-dark text-center font-manrope pb-70 lg-pb-40">
                We're always happy to help you whenever you need our help.
            </p>

            <div class="row gx-xxl-5">
                <div class="col-lg-6">
                    <div class="card-style-sixteen mt-35">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6>Support Center</h6>
                            <img src="{{asset('home/mobile/images/icon/icon_100.svg')}}" alt="">
                        </div>
                        <p class="fs-22">Explore varied resources for quick answers to common inquiries.</p>
                        <a href="{{ config('app.knowledge-base')  }}" class="d-flex align-items-center justify-content-between">Check it out <span class="icon"><i class="fa-light fa-arrow-up-right"></i></span></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card-style-sixteen mt-35">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6>Chat Us</h6>
                            <img src="{{asset('home/mobile/images/icon/icon_101.svg')}}" alt="">
                        </div>
                        <p class="fs-22">Have a quick question that needs to be answered? Chat with a member of the team.</p>
                        <a  class="d-flex align-items-center justify-content-between startChat">Start Chat
                            <span class="icon"><i class="fa-light fa-arrow-up-right"></i></span></a>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_92.svg')}}" alt="" class="shapes shape_01">
    </div>
    <!-- /.contact-section-three -->


@endsection
