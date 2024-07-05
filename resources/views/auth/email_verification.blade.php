<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="author" content="{{$siteName}}" />
    <meta name="description" content="{{$web->description}}" />
    <meta name="keywords" content="{{$web->keywords}}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Bootstrap Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/bootstrap.min.css')}}">
    <!-- Owl Theme Default Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/owl.theme.default.min.css')}}">
    <!-- Owl Carousel Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/owl.carousel.min.css')}}">
    <!-- Animate Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/animate.min.css')}}">
    <!-- Remixicon CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/remixicon.css')}}">
    <!-- boxicons CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/boxicons.min.css')}}">
    <!-- MetisMenu Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/metismenu.min.css')}}">
    <!-- Simplebar Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/simplebar.min.css')}}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/style.css')}}">
    <!-- Dark Mode CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/dark-mode.css')}}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/responsive.css')}}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset($web->favicon)}}">
    <!-- Title -->
    <title>{{$siteName}} - {{$pageName}}</title>

    @include('genericCss')
</head>

<body class="body-bg-f5f5f5">
    <!-- Start Preloader Area -->
    <div class="preloader">
        <div class="content">
            <div class="box"></div>
        </div>
    </div>
    <!-- End Preloader Area -->

    <!-- Start User Area -->
    <section class="user-area">
        <div class="container">
            <div class="user-form-content">
                <h3>{{$pageName}}</h3>

                <form class="user-form" id="registration" method="post" action="{{route('auth.email')}}">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label>Verification Code</label>
                                <input class="form-control" type="number" name="code" />
                            </div>
                        </div>


                        <div class="col-12 mb-4">
                            <button class="default-btn submit" type="submit">
                                Verify Email
                            </button>
                        </div>


                        <div class="col-12">
                            <p class="create">Did not receive the mail?
                                <a data-url="{{ route('auth.email.resend') }}" class="submitResend">Resend</a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- End User Area -->

    <div class="dark-bar">
        <a href="#" class="d-flex align-items-center">
            <span class="dark-title">Enable Dark Theme</span>
        </a>

        <div class="form-check form-switch">
            <input type="checkbox" class="checkbox" id="darkSwitch">
        </div>
    </div>

    <!-- Start Go Top Area -->
    <div class="go-top">
        <i class="ri-arrow-up-s-fill"></i>
        <i class="ri-arrow-up-s-fill"></i>
    </div>
    <!-- End Go Top Area -->

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
    <!-- mixitup Min JS -->
    <script src="{{asset('dashboard/js/mixitup.min.js')}}"></script>
    <!-- Dark Mode Switch Min JS -->
    <script src="{{asset('dashboard/js/dark-mode-switch.min.js')}}"></script>
    <!-- Form Validator Min JS -->
    <script src="{{asset('dashboard/js/form-validator.min.js')}}"></script>
    <!-- Contact JS -->
    <script src="{{asset('dashboard/js/contact-form-script.js')}}"></script>
    <!-- Ajaxchimp Min JS -->
    <script src="{{asset('dashboard/js/ajaxchimp.min.js')}}"></script>
    <!-- Custom JS -->
    <script src="{{asset('dashboard/js/custom.js')}}"></script>
    @include('basicInclude')
    <script src="{{asset('requests/auth/register.js')}}"></script>
    <script>
        $(function(){
            $('.submitResend').click(function(){
                let url = $(this).data('url');
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: "POST",
                dataType:"json",
                beforeSend:function(){
                    $('.submit').attr('disabled', true);
                    $("#registration :input").prop("readonly", true);
                    $(".submit").LoadingOverlay("show",{
                        text        : "please wait ...",
                        size        : "20"
                    });
                },
                success:function(data)
                {
                    if(data.error === 'ok')
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#registration :input").prop("readonly", false);
                            // window.location.replace(data.data.redirectTo)
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(errorThrown);
                    $("#registration :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");
                },
            });
            })
        })
    </script>
</body>

</html>