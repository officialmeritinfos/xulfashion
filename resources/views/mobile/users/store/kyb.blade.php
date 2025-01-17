@extends('mobile.users.layout.base')
@section('content')
    <div class="container-fluid mt-4">
        <livewire:mobile.users.store.components.business-verification :store="$store" lazy/>
    </div>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                window.addEventListener('verificationSent', event => {
                    let url = event.detail.url;
                    setTimeout(() => {
                        window.location.href = url;
                    }, 5000);
                });
            });
        </script>
    @endpush
@endsection
