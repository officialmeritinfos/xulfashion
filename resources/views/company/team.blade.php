@extends('company.layout.base')
@section('content')

    <!--
		=====================================================
			Team Section One
		=====================================================
		-->
    <div class="team-section-one position-relative z-1 mt-225 xl-mt-200 lg-mt-150 pb-150 lg-pb-80">
        <div class="container">
            <div class="position-relative">
                <div class="title-two text-center mb-30 lg-mb-10">
                    <h2>Our Talented Team</h2>
                </div>

                <div class="row">
                    @foreach($teams as $team)
                        <div class="col-lg-3 col-md-6">
                            <div class="team-block mt-45">
                                <img src="{{asset('home/mobile/team/'.$team->photo)}}" alt="" class="w-100 img" style="height: 300px;">
                                <div class="text">
                                    <span>{{$team->position}}</span>
                                    <h5>{{$team->name}}</h5>
                                    <a href="#" class="stretched-link"></a>
                                </div>
                            </div>
                            <!-- /.team-block -->
                        </div>
                    @endforeach
                </div>
                <div class="position-relative text-center mt-80 lg-mt-50">
                    <div class="row">
                        <div class="col-lg-8 m-auto">
                            <h2 class="font-manrope mb-40">Join us & create magic</h2>
                        </div>
                    </div>
                    <a href="" class="btn-twenty">Join Now!!</a>
                </div>
            </div>
        </div>
        <img src="images/shape/shape_91.svg" alt="" class="shapes shape_02">
    </div>
    <!-- /.team-section-one -->

@endsection
