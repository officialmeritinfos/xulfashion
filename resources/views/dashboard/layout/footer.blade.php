<!-- Jquery Min JS -->
<script src="{{asset('dashboard/js/jquery.min.js')}}"></script>
<!-- Bootstrap Bundle Min JS -->
<script src="{{asset('dashboard/js/bootstrap.bundle.min.js')}}"></script>
<!-- Owl Carousel Min JS -->
<script src="{{asset('dashboard/js/owl.carousel.min.js')}}"></script>
<!-- Metismenu Min JS -->
<script src="{{asset('dashboard/js/metismenu.min.js')}}"></script>
<!-- Simplebar Min JS -->
<script src="{{asset('dashboard/js/simplebar.min.js')}}"></script>
<!-- Mixitup Min JS -->
<script src="{{asset('dashboard/js/mixitup.min.js')}}"></script>
<!-- Dark Mode Switch Min JS -->
<script src="{{asset('dashboard/js/dark-mode-switch.min.js')}}"></script>
<!-- Apexcharts Min JS -->
<script src="{{asset('dashboard/js/apexcharts/apexcharts.min.js')}}"></script>
<!-- Form Validator Min JS -->
<script src="{{asset('dashboard/js/form-validator.min.js')}}"></script>
<!-- Contact JS -->
<script src="{{asset('dashboard/js/contact-form-script.js')}}"></script>
<!-- Ajaxchimp Min JS -->
<script src="{{asset('dashboard/js/ajaxchimp.min.js')}}"></script>
<!-- Custom JS -->
<script src="{{asset('dashboard/js/custom.js')}}"></script>
@include('basicInclude')
@stack('js')

<script src="{{asset('dashboard/vendors/summernote/summernote-bs5.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 150,
        });
    });
</script>

<script src="{{asset('requests/dashboard/sendOtp.js')}}"></script>
