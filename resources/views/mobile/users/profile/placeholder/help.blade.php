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
    <section class="section-b-space pt-0">
        <div class="custom-container">
            <div class="help-center empty-tab">
                <img class="img-fluid" src="{{asset('mobile/images/banner/help-pic.png')}}" alt="" style="width: 150px;"/>
                <h2>Help Center</h2>
                <p>Please get in touch and we will be happy to help you. Get quick customer support by using any of these channels.</p>
                <div class="row mt-4">

                    <ul class="profile-list">
                        @if(!empty($web->phone))
                            <!-- Email Card -->
                            <li class="col-12 mb-3 cpy" data-clipboard-text="{{$web->phone}}">
                                <span class="profile-box">
                                    <div class="profile-img">
                                        <i class="iconsax icon" data-icon="phone"></i>
                                    </div>
                                    <div class="profile-details">
                                        <h4>Call Support</h4>
                                        <p class="mb-0">Click to copy</p>
                                    </div>
                                </span>
                            </li>
                        @endif
                        <!-- Email Card -->
                        <li class="col-12 mb-3 cpy" data-clipboard-text="{{$web->supportEmail}}">
                            <span class="profile-box">
                                <div class="profile-img">
                                    <i class="iconsax icon" data-icon="mail"></i>
                                </div>
                                <div class="profile-details">
                                    <h4>Email Support</h4>
                                    <p class="mb-0">Click to copy</p>
                                </div>
                            </span>
                        </li>

                        <li class="col-12 mb-3" onclick="openLiveChat()">
                            <span class="profile-box">
                                <div class="profile-img">
                                    <i class="iconsax icon" data-icon="messages-4"></i>
                                </div>
                                <div class="profile-details">
                                    <h4>Live Chat</h4>
                                    <p class="mb-0">Click to start conversation</p>
                                </div>
                            </span>
                        </li>
                    </ul>
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

        </script>

    @endpush
@endsection
