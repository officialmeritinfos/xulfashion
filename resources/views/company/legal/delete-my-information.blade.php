@extends('company.layouts.base')
@section('content')

    <section class="saas_banner_area contact_banner_area" data-bg-color="#fff">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="saas_banner_content a_banner_content pt-5 pe-5">
                        <h2>Request <span class="ornaments">Account</span>
                            Deletion
                        </h2>
                        <p>
                            We will never hold your data against your will except where retention is required by law.
                            Fill the form below to get started with the process.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 d-flex justify-content-end">
                    <div class="banner_right">
                        <div class="overlay" data-bg-color="#108BD0"></div>
                        <div class="about_banner_img mr-130">
                            <img src="{{asset('home/main/img/delete.svg')}}" alt="">
                        </div>
                        <ul class="list-unstyled dashboard_img_shap">
                            <li><img src="{{asset('home/main/img/integration/integra_banner_shap.png')}}" alt=""></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <livewire:company.legal.delete-my-information />


@endsection
