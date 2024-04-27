@extends('dashboard.layout.base')
@section('content')
    <div class="container-fluid">
        <div class="ui-kit-cards grid mb-24">
            <div class="col-12">
                <label for="inputEmail4" class="form-label">Choose Account Type</label>
                <div class="boxed-check-group boxed-check-primary row">
                    <label class="boxed-check col-md-4">
                        <input class="boxed-check-input" type="radio" name="accountType" value="1">
                        <div class="boxed-check-label" style="text-align:center;">
                            <h2>Tutor</h2>
                            <span>You are a qualified tutor in your field and looking for employment</span>
                        </div>
                    </label>
                    <label class="boxed-check col-md-4">
                        <input class="boxed-check-input" type="radio" name="accountType" value="2">
                        <div class="boxed-check-label" style="text-align:center;">
                            <h2>Parent</h2>
                            <span>You are looking for a tutor for your child(ren) or ward</span>
                        </div>
                    </label>
                    <label class="boxed-check col-md-4">
                        <input class="boxed-check-input" type="radio" name="accountType" value="3">
                        <div class="boxed-check-label" style="text-align:center;">
                            <h2>School</h2>
                            <span>You want to employ tutors for your school or you are a recruiter.</span>
                        </div>
                    </label>
                </div>
            </div>
            @include('dashboard.components.completeProfile.parent_complete_profile')
            @include('dashboard.components.completeProfile.school_complete_profile')
            @include('dashboard.components.completeProfile.tutor_complete_profile')
        </div>

    </div>
    @push('js')
        <script>
            //display form content on account  type selection
            $('input[name="accountType"]').on('click',function (){
                var value = Number($(this).val());

                if (value===1){
                    setTimeout(()=>{
                        $('#tutorData').slideToggle();
                        $('#schoolData').fadeOut();
                        $('#parentData').fadeOut();
                    },100)
                }else if(value===2){
                    $('#tutorData').fadeOut();
                    $('#schoolData').fadeOut();
                    $('#parentData').slideToggle();
                }
                else{
                    $('#tutorData').fadeOut();
                    $('#schoolData').slideToggle();
                    $('#parentData').fadeOut();
                }
            });
            //display form content on account  type selection
            $('input[name="currentlyEmployed"]').on('click',function (){
                var valv = Number($(this).val());
                if (valv===1){
                    setTimeout(()=>{
                        $('#currentlyEmployed').slideToggle();
                    },100)
                }else{
                    $('#currentlyEmployed').fadeOut();
                }

            })
        </script>

        <script src="{{asset('requests/auth/completeProfile.js')}}"></script>
    @endpush
@endsection
