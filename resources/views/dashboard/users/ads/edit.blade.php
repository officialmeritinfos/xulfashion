@extends('dashboard.layout.base')
@section('content')
    @push('css')
        <style>
            .image-grid .image-item {
                width: 100%;
                height: auto;
            }
        </style>
    @endpush
    <div class="ui-kit-cards grid mb-24">
        <form class="row g-3" id="processForm" action="{{route('user.ads.edit.process',['id'=>$ad->reference])}}" method="post">
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Select Location<sup class="text-danger">*</sup></label>
                <select class="form-control form-control-lg selectize" id="inputState" name="location">
                    <option value="">Select a Location</option>
                    @foreach($states as $state)
                        <option value="{{$state->iso2}}" {{($state->iso2==$ad->state)?'selected':''}}>{{$state->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="inputAddress" class="form-label">Featured Photo<i class="ri-information-fill" data-bs-toggle="tooltip"
                    title="Selecting a new image will replace existing featured image"></i> </label>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" id="inputGroupFile02" name="featuredPhoto" accept="image/*">
                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                </div>
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Title<sup class="text-danger">*</sup></label>
                <input type="text" class="form-control form-control-lg" id="inputAddress" placeholder="Title" name="title"
                value="{{$ad->title}}">
            </div>
            <div class="col-md-6">
                <label for="inputAddress2" class="form-label">Company Name</label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="Company name" name="companyName"
                value="{{$ad->companyName}}">
            </div>
            <div class="col-md-6">
                <label for="inputCity" class="form-label">Type of Service<sup class="text-danger">*</sup></label>
                <select class="form-control form-control-lg selectize" id="inputCity" name="serviceType">
                    <option value="">Select an option</option>
                    @foreach($services as $service)
                        <option value="{{$service->id}}" {{($service->id==$ad->serviceType)?'selected':''}}>{{$service->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label for="inputState" class="form-label">Description<sup class="text-danger">*</sup></label>
                <textarea class="form-control" rows="5" name="description" id="inputState">{{$ad->description}}</textarea>
            </div>
            <div class="col-12 row mt-2">
                <label for="inputPrice" class="form-label">Price<sup class="text-danger">*</sup></label>
                <div class="col-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input boxed-check-success" type="radio" name="priceType" id="priceType" value="1"
                            {{($ad->priceType==1)?'checked':''}}>
                        <label class="form-check-label" for="priceType">Contact for price</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input boxed-check-success" type="radio" name="priceType" id="priceType2" value="2"
                               {{($ad->priceType==2)?'checked':''}}>
                        <label class="form-check-label" for="priceType2">Specify price</label>
                    </div>
                </div>
                <div class="col-md-12 price">
                    <input type="text" class="form-control" id="price" placeholder="Price" name="price" value="{{$ad->amount}}">
                </div>
            </div>
            <div class="col-12 mt-3 negotiate">
                <label for="inputPrice" class="form-label">Are you open to negotiation?</label>
                <div class="col-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input boxed-check-success" type="radio" name="negotiate" id="negotiate1" value="1"
                            {{($ad->openToNegotiation==1)?'checked':''}}>
                        <label class="form-check-label" for="negotiate1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input boxed-check-success" type="radio" name="negotiate" id="negotiate2" value="2"
                            {{($ad->openToNegotiation==2)?'checked':''}}>
                        <label class="form-check-label" for="negotiate2">No</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input boxed-check-success" type="radio" name="negotiate" id="negotiate3" value="3"
                            {{($ad->openToNegotiation==3)?'checked':''}}>
                        <label class="form-check-label" for="negotiate3">Not Sure</label>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <label for="inputAddress" class="form-label">Your Contact Number</label>
                <input type="text" class="form-control form-control-lg" id="inputAddress" value="{{$user->phone}}" disabled>
            </div>
            <div class="col-6">
                <label for="inputAddress" class="form-label">Your Name</label>
                <input type="text" class="form-control form-control-lg" id="inputAddress" value="{{$user->name}}" disabled>
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Category</label>
                <input type="text" class="form-control form-control-lg selectizeAdd" id="inputAddress" name="category[]"
                value="{{$ad->tags}}">
            </div>

            <div class="col-12 text-center mt-5">
                <button type="submit" class="default-btn submit">Update Ad</button>
            </div>
        </form>
    </div>

    @push('js')
        <script>
            $(function (){
                $('input[name="priceType"]').on('click',function (){
                    let values = $(this).val();
                    if (Number(values)===2 ){
                        $('.price').show();
                        $('.negotiate').show();
                    }else{
                        $('.price').hide();
                        $('.negotiate').hide();
                    }
                });
            });

            if($('input[name="priceType"]').is(':checked')){
                let vals = $("input[name='priceType']:checked").val();
                if (Number(vals)===2 ){
                    $('.price').show();
                    $('.negotiate').show();
                }else{
                    $('.price').hide();
                    $('.negotiate').hide();
                }
            }
        </script>
        <script src="{{asset('requests/dashboard/user/ads.js')}}"></script>
    @endpush

@endsection
