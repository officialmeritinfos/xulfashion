<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css"
      integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{asset('dashboard/css/selectize.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('dashboard/vendors/lightboxed/lightboxed.css')}}">
{{--<link rel="stylesheet" href="{{asset('dashboard/vendors/iconpicker/fontawesome-browser.css')}}">--}}
@if(url()->current()!=route('mobile.base') && url()->current()!=route('mobile.index') && url()->current()!=route('mobile.ads.index'))
    <script src="https://www.google.com/recaptcha/api.js" defer></script>
@endif

<link rel="stylesheet" href="{{asset('dashboard/vendors/summernote/summernote-bs5.css')}}">
<style>
    .loader-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: inherit;
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .loader {
        width: 500px;
        height: 25px;
        background: linear-gradient(to right, #ddd 25%, #4285f4 50%, #ddd 75%);
        background-size: 200% 100%;
        animation: shimmer 2s infinite linear;
    }

    @keyframes shimmer {
        0% {
            background-position: 200% 0;
        }
        100% {
            background-position: -200% 0;
        }
    }
</style>
