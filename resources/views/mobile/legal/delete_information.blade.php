@extends('mobile.ads.layout.innerBase')
@section('content')

    <!-- help section start -->
    <section class="section-b-space">
        <div class="custom-container">
            <div class="help-center">
                <img class="img-fluid help-pic" src="{{asset('home/main/img/delete.svg')}}" alt="help" />
                <h2>Request for Account Deletion</h2>
                <p>
                    We will never hold your data against your will except where retention is required by law. Fill the form below to get started with the process.
                    <br/>
                    <b>Note:</b> You will need to verify this action from your email.
                </p>


                <div class="accordion accordion-flush help-accordion" id="accordionFlushExample">
                    <livewire:company.mobile.delete-my-information />
                </div>
            </div>
        </div>
    </section>
    <!-- help section end -->

@endsection
