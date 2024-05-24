@extends('dashboard.layout.base')
@section('content')

    <div class="ui-kit-card mb-24">
        <h3>Store-front Templates</h3>

        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach($themes as $theme)
                <div class="col-lg-6"  @if($theme->comingSoon==1) data-bs-toggle="tooltip" title="Coming soon - Under development" @endif>
                    <div class="card">
                        <img src="{{asset('templates/'.$theme->featuredImage)}}" class="card-img-top" >
                        <div class="card-body">
                            <h5 class="card-title">{{$theme->theme}}</h5>

                            <div class="d-flex mt-3 row">
                                <div class="col-6">
                                    @if($theme->id ==$store->theme)
                                        <a href="{{route('user.stores.theme.customize')}}"  class="btn btn-primary">
                                            Customize
                                        </a>
                                    @else
                                        <form action="{{route('user.stores.theme.activate',['id'=>$theme->id])}}" method="post">
                                            <button  class="btn btn-primary" {{($theme->comingSoon==1)?'disabled':''}}>
                                                Activate
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <div class="col-6 text-end">
                                    <a href="{{asset('templates/'.$theme->videoPreview)}}" class="btn btn-light lightboxed" target="_blank">
                                        Preview
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>


@endsection
