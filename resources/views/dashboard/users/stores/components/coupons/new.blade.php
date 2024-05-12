@extends('dashboard.layout.base')
@section('content')

    <div class="submit-property-area">
        <div class="container-fluid">
            <form class="submit-property-form" id="processForm" action="{{route('user.stores.coupons.new.process')}}" method="post">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="inputTitle" class="form-label">Coupon Code<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="inputTitle" name="name" >
                    </div>
                    <div class="col-md-6 row mt-2">
                        <label for="inputPrice" class="form-label">Coupon Type<sup class="text-danger">*</sup></label>
                        <div class="col-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input boxed-check-success" type="radio" name="couponType" id="couponType" value="1">
                                <label class="form-check-label" for="priceType">Percentage</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input boxed-check-success" type="radio" name="couponType" id="couponType2" value="2"
                                       checked>
                                <label class="form-check-label" for="priceType2">Flat</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 price">
                        <label for="inputPrice" class="form-label">Coupon Discount<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="price" placeholder="discount" name="discount">
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-check">
                            <input class="form-check-input" value="1" type="checkbox" id="useLimit"
                                   name="useLimit">
                            <label class="form-check-label" for="useLimit">
                               Limit Coupon by number of Usage
                                <i class="ri-information-fill" data-bs-toggle="tooltip"
                                   title="This will deactivate the coupon once a specific number of usage is reached."></i>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 usageLimit mt-3" style="display: none;">
                        <label for="inputState" class="form-label">Usage Limit<sup class="text-danger">*</sup></label>
                        <input type="number" class="form-control" id="price" placeholder="Usage Limit" name="usageLimit">
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-check">
                            <input class="form-check-input" value="1" type="checkbox" id="couponEnd"
                                   name="couponEnd" checked>
                            <label class="form-check-label" for="couponEnd">
                               Deactivate Coupon By Date
                                <i class="ri-information-fill" data-bs-toggle="tooltip"
                                   title="This will automatically deactivate the coupon once the date set below is reached. Uncheck to make it unlimited."></i>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 couponDeadline mt-3">
                        <label for="inputState" class="form-label">Coupon Deadline<sup class="text-danger">*</sup></label>
                        <input type="date" class="form-control" id="price" placeholder="Deadline" name="deadline">
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-check">
                            <input class="form-check-input" value="1" type="checkbox" id="addAnother"
                                   name="addAnother">
                            <label class="form-check-label" for="addAnother">
                                Add another coupon
                            </label>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="default-btn submit">Add Coupon</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            $(function (){
                $('input[name="useLimit"]').on('click',function (){
                    if($('input[name="useLimit"]').is(':checked')){
                        $('.usageLimit').show();
                    }else{
                        $('.usageLimit').hide();
                    }
                });
                $('input[name="couponEnd"]').on('click',function (){
                    if($('input[name="couponEnd"]').is(':checked')){
                        $('.couponDeadline').show();
                    }else{
                        $('.couponDeadline').hide();
                    }
                });
            });
            if($('input[name="useLimit"]').is(':checked')){
                $('.usageLimit').show();
            }else{
                $('.usageLimit').hide();
            }
            if($('input[name="couponEnd"]').is(':checked')){
                $('.couponDeadline').show();
            }else{
                $('.couponDeadline').hide();
            }
        </script>
        <script src="{{asset('requests/dashboard/user/stores.js')}}"></script>
    @endpush
@endsection
