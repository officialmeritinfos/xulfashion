@extends('dashboard.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')

    <div class="blog-details-content">

        <div class="blog-top-content">
            <div class="blog-content">
                <ul class="admin">
                    <li>
                        <a href="#">
                            <i class="ri-user-3-fill"></i>
                            {{empty($employer->companyName)?$employer->name:$employer->companyName}}
                        </a>
                    </li>

                    <li>
                        <i class="ri-calendar-2-line"></i>
                       {{date('F d, Y',strtotime($job->created_at))}}
                    </li>

                    <li>
                        <a href="#">
                            <i class="ri-discuss-line"></i>
                            {{($job->numberOfApplication==0)?'No applications':$job->numberOfApplication.' application(s)'}}
                        </a>
                    </li>
                </ul>

                <h3>Job Descriptions</h3>
                <p>
                    {!! str_replace(['<br>','<p>','</p>'],'',html_entity_decode($job->description) ) !!}
                </p>
                <div class="gap-mb-20"></div>
            </div>

            <h3>Requirements</h3>
            <p>
                {!! str_replace(['<br>','<p>','</p>'],'',html_entity_decode($job->requirements)) !!}
            </p>
        </div>

        <div class="tags">
            <ul class="tag-link">
                <li class="title">
                    <i class="ri-price-tag-line"></i>
                </li>
                <li>
                    <a href="#" target="_blank">
                        {{$job->currency}}{{$injected->shortenNumberToLetters($job->amount,2)}} {{$injected->paymentType($job->paymentType)->name}}
                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">
                        {{$injected->jobTypeById($job->typeOfJob)->name}}
                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">
                        {{$job->country}}, {{$job->state}}
                    </a>
                </li>
            </ul>
        </div>

        <div class="leave-reply">
            <h3>Apply Below</h3>

            <form method="post" action="{{route('user.job.id.apply',['id'=>$job->reference])}}" id="applyForJob">
                <p>Your email address will not be published. Required fields are marked*. By Default, your existing CV is submitted</p>
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-group">
                            <label>Name*</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}" readonly>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6">
                        <div class="form-group">
                            <label>Email*</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{$user->email}}" readonly>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label>Cover Letter* <i class="ri-information-fill" data-bs-toggle="tooltip" title="By default we prefill your cover-letter with
                            the cover-letter dummy you set in your settings."></i> </label>
                            <textarea name="coverLetter" class="form-control summernote" id="message" rows="8">{!! $user->coverletter !!}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input hasCv" type="checkbox" id="gridCheck" name="hasCv" value="1">
                            <label class="form-check-label" for="gridCheck">
                                Upload another CV
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3 cv" style="display: none;">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" id="inputGroupFile02" name="Cv" accept="application/pdf">
                                <label class="input-group-text" for="inputGroupFile02">Upload CV</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 text-center">
                        <button type="submit" class="default-btn submit">
                            Submit Application
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            $(function (){
                $('input[name="hasCv"]').click(function(){
                    if($(this).prop("checked") == true){
                        $('.cv').show();
                    }
                    else if($(this).prop("checked") == false){
                        $('.cv').hide();
                    }
                });
            });
        </script>
        <script src="{{asset('requests/dashboard/tutor/job.js')}}"></script>
    @endpush
@endsection
