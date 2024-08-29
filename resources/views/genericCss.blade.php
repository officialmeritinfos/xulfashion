<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css"
      integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{asset('dashboard/css/selectize.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('dashboard/vendors/lightboxed/lightboxed.css')}}">
{{--<link rel="stylesheet" href="{{asset('dashboard/vendors/iconpicker/fontawesome-browser.css')}}">--}}

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
        position: relative;
        display: flex;
    }

    .loader:before,
    .loader:after {
        content: '';
        width: 15px;
        height: 15px;
        display: inline-block;
        position: relative;
        margin: 0 5px;
        border-radius: 50%;
        color: #E8175E;
        background: currentColor;
        box-shadow: 50px 0, -50px 0;
        animation: left 1s infinite ease-in-out;
    }

    .loader:after {
        color: #FF3D00;
        animation: right 1.1s infinite ease-in-out;
    }

    @keyframes right {
        0%, 100% {
            transform: translateY(-10px);
        }
        50% {
            transform: translateY(10px);
        }
    }

    @keyframes left {
        0%, 100% {
            transform: translateY(10px);
        }
        50% {
            transform: translateY(-10px);
        }
    }
</style>
