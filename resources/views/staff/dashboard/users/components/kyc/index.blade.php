@extends('staff.dashboard.layout.base')
@section('content')

    <livewire:staff.users.components.merchant.kyc.kyc-list :userId="$merchant->reference">


        @push('js')
            <script>
                // ================== Image Upload Js Start ===========================
                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                            $('#imagePreview').hide();
                            $('#imagePreview').fadeIn(650);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                $("#imageUpload").change(function() {
                    readURL(this);
                });
                // ================== Image Upload Js End ===========================
            </script>

    @endpush
@endsection
