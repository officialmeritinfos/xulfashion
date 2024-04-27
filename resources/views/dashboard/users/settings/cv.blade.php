@extends('dashboard.layout.base')
@section('content')

    @if(!empty($user->tutorCv))
        <div class="container-fluid">
            <div class="ui-kit-card mb-24">
                <h3>Uploaded CV</h3>
                <a href="{{$user->tutorCv}}" target="_blank" type="button" class="btn btn-primary" id="liveAlertBtn">
                    <i class="ri-file-upload-fill"></i>
                </a>
            </div>
        </div>
    @endif
    <div class="submit-property-area">
        <div class="container-fluid">
            <form class="submit-property-form" id="cvSetting" action="{{route('user.settings.cv.update')}}">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Your CV Upload</label>
                            <div class="file-upload">
                                <input type="file" name="cv" id="file" class="inputfile" accept="application/msword, application/pdf">
                                <label class="upload" for="file">
                                    <i class="ri-file-pdf-line"></i>
                                    Upload CV/Resume
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Cover Letter</label>
                            <textarea type="text" class="form-control summernote" placeholder="Enter your COver letter" name="coverLetter">
                                @if(empty($user->coverLetter))
                                    <p>Dear {manager},</p>

                                    <p>I am writing to express my interest in the {jobtitle} position, as advertised on {site}. With 4 years of experience in education, I am confident in my ability to contribute effectively to your team.</p>

                                    <p>Throughout my career, I have honed my skills in curriculum development, classroom management, and student engagement. My previous roles have equipped me with a strong foundation in fostering a positive learning environment and ensuring the academic success of my students, which I believe aligns well with the requirements of the {jobtitle} position .</p>

                                    <p>I am eager to bring my passion for education to your institution and contribute to the academic growth and development of your students.</p>


                                    <p>I am enthusiastic about the possibility of joining your team and would welcome the opportunity to discuss how my skills and experiences align with the needs of the {jobtitle} position. Thank you for considering my application. I look forward to the possibility of contributing to the success of your students.</p>

                                    <p>Sincerely,</p>

                                    <p>{name}<br>
                                @else
                                    {!! $user->coverLetter !!}
                                @endif
                            </textarea>
                            <small class="text-primary">The prefilled is data is only a sample. Edit it to your own taste.</small>
                        </div>
                    </div>


                    <div class="col-lg-12 text-center mt-4">
                        <button type="submit" class="default-btn submit">
                            Save Change
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script src="{{asset('requests/dashboard/tutor/settings.js')}}"></script>
    @endpush
@endsection
