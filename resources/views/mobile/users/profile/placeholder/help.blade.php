@extends('mobile.users.layout.plainBase')
@section('content')

    @push('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <style>
            .card:hover {
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            }

            .icon {
                font-size: 30px;
                color: #007bff;
                margin-right: 20px;
            }

            .card-body {
                display: flex;
                align-items: center;
            }
        </style>
    @endpush

    <!-- help section start -->
    <section class="section-b-space">
        <div class="custom-container">
            <div class="help-center">
                <img class="img-fluid help-pic" src="{{asset('mobile/images/banner/help-pic.png')}}" alt="help" />
                <h2>Help Center</h2>
                <p>Please get in touch and we will be happy to help you. Get quick customer support by using any of these channels.</p>
                <div class="row mt-4">
                    @if(!empty($web->phone))
                        <!-- Phone Card -->
                        <div class="col-12 mb-3">
                            <div class="card cpy" style="cursor: pointer;" data-clipboard-text="{{$web->phone}}">
                                <div class="card-body d-flex align-items-center">
                                    <i class="fas fa-phone icon me-3"></i>
                                    <div>
                                        <h3 class="mb-1">Call Support</h3>
                                        <p class="mb-0">Click to copy support number</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Email Card -->
                    <div class="col-12 mb-3">
                        <div class="card" onclick="sendEmail()" style="cursor:pointer;">
                            <div class="card-body">
                                <i class="fas fa-envelope icon"></i>
                                <h3>Email Support</h3>
                            </div>
                        </div>
                    </div>


                    <!-- Live Chat Card -->
                    <div class="col-12 mb-3">
                        <div class="card" onclick="openLiveChat()" style="cursor:pointer;">
                            <div class="card-body">
                                <i class="fas fa-comments icon"></i>
                                <h3>Live Chat Support</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @push('js')
        <!-- Tawk.to Widget (Initially hidden) -->
        <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            window.Tawk_API.onLoad = function(){
                window.Tawk_API.hideWidget();
            };
            window.Tawk_API.onChatEnded = function(){
                window.Tawk_API.hideWidget();
            };
            window.Tawk_API.onChatMinimized = function(){
                window.Tawk_API.hideWidget();
            };

            (function(){
                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                s1.async=true;
                s1.src='https://embed.tawk.to/669a2d06becc2fed69278138/1i353vojt';
                s1.charset='UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
            })();

            Tawk_API.visitor={
                name:"{{$user->name}}",
                email:"{{$user->email}}",
            }


            function openLiveChat() {
                Tawk_API.showWidget();
                Tawk_API.maximize();

            }

            function sendEmail() {
                window.open("mailto:{{$web->supportEmail}}", '_blank');
                window.location.reload();
            }
        </script>

    @endpush
@endsection
