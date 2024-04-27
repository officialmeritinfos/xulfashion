@extends('dashboard.layout.base')
@section('content')

    <div class="profile-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5">
                    <div class="cover-img">
                        <img src="{{asset('dashboard/images/cover-img.jpg')}}" alt="Images">
                    </div>

                    <div class="profile-face">
                        <div class="row align-items-end justify-content-center">
                            <div class="col-lg-4 col-md-4">
                                <div class="avatar">
                                    <img src="{{$user->photo}}" alt="Images" style="width: 100px;">
                                    <h6>{{$user->name}}</h6>
                                    <p>Tutor</p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6 col-md-4">
                                <div class="projects">
                                    <h6>{{$user->tutorMinHour}} - {{$user->tutorMaxHour}} Hours</h6>
                                    <p>Work hour Weekly</p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6 col-md-4">
                                <div class="projects">
                                    <h6>{{$fiat->sign}}{{number_format($user->workRate,2)}}</h6>
                                    <p>{{$rateType->name}} Salary</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="profile-information">
                        <h6>Information</h6>
                        <p>
                            {!! $user->bio !!}
                        </p>

                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <tbody>
                                <tr>
                                    <th scope="row">Full Name :</th>
                                    <td>{{$user->name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Display Name :</th>
                                    <td>{{$user->displayName??'N/A'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Mobile :</th>
                                    <td>
                                        <a href="tel:{{$user->phone}}">{{$user->phone}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">E-mail :</th>
                                    <td>
                                        <a href="mailto:{{$user->email}}">
                                            <span>{{$user->email}}</span>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Location :</th>
                                    <td>{{$user->country}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="profile-experience analytics-area"  data-simplebar>
                        <h6>Work Experience
                            <i class="ri-edit-2-fill"
                               data-bs-target="#addExperience"
                               data-bs-toggle="modal"></i>
                            <i class="ri-delete-bin-3-fill text-danger p-3"
                               data-bs-target="#truncateExperience"
                               data-bs-toggle="modal"></i>
                        </h6>
                        @if($experiences->count()>0)
                            <ul>
                                @php $cnt=1; @endphp
                                @foreach($experiences as $experience)
                                    <li>
                                        <a>
                                            <span>{{$cnt}}</span>
                                            {{$experience->name}}
                                            <i class="ri-edit-2-fill"
                                               data-bs-target="#editExperience" data-bs-toggle="modal"
                                               data-value="{{$experience->id}}"
                                               data-title="{{$experience->name}}"
                                               data-start="{{$experience->timeStart}}"
                                               data-finish="{{$experience->timeEnd}}"
                                               data-employer="{{$experience->employer}}"
                                               data-address="{{$experience->address}}"
                                               data-description="{!! $experience->content !!}"></i>
                                            <i class="ri-delete-bin-3-fill text-danger"
                                               data-bs-target="#deleteExperience" data-bs-toggle="modal"
                                               data-value="{{$experience->id}}" data-title="{{$experience->name}}"></i>

                                            @if($experience->isCurrent==1)
                                                <p>{{date('Y',strtotime($experience->timeStart))}} to Present</p>
                                            @else
                                                <p>{{date('Y',strtotime($experience->timeStart))}} to {{date('Y',strtotime($experience->timeEnd))}}</p>
                                            @endif
                                        </a>
                                    </li>
                                    @php $cnt=$cnt+1; @endphp
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="col-lg-7">

                    <div class="analytics-area ">
                        <div class="activity-timeline h-auto" data-simplebar>
                            <h3>Skills
                                <i class="ri-add-box-line"
                                   data-bs-target="#addSkill"
                                   data-bs-toggle="modal"></i>
                                <i class="ri-delete-bin-3-fill text-danger p-3"
                                   data-bs-target="#truncateSkills"
                                   data-bs-toggle="modal"></i>
                            </h3>
                            @if($skills->count()>0)
                                <ul>
                                    @foreach($skills as $skill)
                                        <li>
                                            <a>
                                                <i class="ri-add-line"></i>
                                                <h6 class="text-start">
                                                    {{$skill->name}}
                                                    <i class="ri-delete-bin-3-fill text-danger"
                                                       data-bs-target="#deleteSkills" data-bs-toggle="modal"
                                                       data-value="{{$skill->id}}" data-title="{{$skill->name}}"></i>
                                                </h6>
                                                <span class="badge bg-primary text-end">{{$skill->level*10}}%</span>
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                            @endif
                        </div>
                    </div>

                    <div class="analytics-area ">
                        <div class="activity-timeline h-auto" data-simplebar>
                            <h3>Certifications
                                <i class="ri-edit-2-fill"
                                   data-bs-target="#addCertification"
                                   data-bs-toggle="modal"></i>
                                <i class="ri-delete-bin-3-fill text-danger p-3"
                                   data-bs-target="#truncateCertifications"
                                   data-bs-toggle="modal"></i>
                            </h3>
                            @if($certifications->count()>0)
                                <ul>
                                    @foreach($certifications as $certification)
                                        <li>
                                            <a>
                                                <h6 class="text-start">
                                                    {{$certification->name}}<sup><small class="badge bg-primary">{{($certification->certType==1)?'Certificate':'Award'}}</small></sup>
                                                    <i class="ri-delete-bin-3-fill text-danger"
                                                       data-bs-target="#deleteCertifications" data-bs-toggle="modal"
                                                       data-value="{{$certification->id}}" data-title="{{$certification->name}}"></i>
                                                </h6>
                                                <p>
                                                    Issued by {{$certification->organization}}
                                                    <sup>
                                                        <small class="badge bg-primary text-end">{{($certification->isPublic==1)?'Public':'Private'}}</small>
                                                    </sup>
                                                </p>

                                                @if(!empty($certification->link))
                                                    <a href="{{$certification->link}}" target="_blank" class="default-btn">View Certificate</a>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                            @endif
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


    @push('js')
        @include('dashboard.users.portfolios.modals.experience_modal')
        @include('dashboard.users.portfolios.modals.skills_modal')
        @include('dashboard.users.portfolios.modals.certification_modal')
        <script src="{{asset('requests/dashboard/tutor/experience.js')}}"></script>
        <script src="{{asset('requests/dashboard/tutor/skills.js')}}"></script>
        <script src="{{asset('requests/dashboard/tutor/certification.js')}}"></script>
    @endpush
@endsection
