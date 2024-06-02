@extends('storefront.theme1.layout.base')
@section('content')
    @inject('options','App\Custom\Storefront')
    <!--start breadcrumb-->
    <div class="py-4 border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('merchant.store',['subdomain'=>$subdomain])}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$pageName}}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <!--start product details-->
    <section class="section-padding">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-xl-12">
                    <h3 class="fw-bold">{{$pageName}}</h3>
                    <p>
                        {!! $store->returnPolicy !!}
                    </p>
                </div>
            </div><!--end row-->

        </div>
    </section>
    <!--start product details-->



@endsection
