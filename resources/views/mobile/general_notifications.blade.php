@include('genericJs')
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
<script>
    $('.tagify').each(function() {
        new Tagify(this);
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Select all elements with the data-bs-toggle="tooltip" attribute
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

        // Initialize each tooltip
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    $(function () {
        $('[data-bs-toggle="popover"]').popover();
    });
</script>
<style>
    .form-label{
        font-size: 12px;
    }
    .form-check-label{
        font-size: 13px;
    }
    body.dark .form-label{
        font-size: 12px;
        color:#fff2fe;
    }
    body.dark .form-check-label{
        font-size: 13px;
        color: #fff2fe;
        margin: 2px;
    }
    body.dark .form-control{
        background-color:rgb(18, 38, 54);
        color: #fff2fe;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css"
      integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    var firebaseConfig = {
        apiKey: "AIzaSyAu-UlGhH7XukmLzt6FozR1HfBOofrv1bc",
        authDomain: "nextropay-testing.firebaseapp.com",
        projectId: "nextropay-testing",
        storageBucket: "nextropay-testing.appspot.com",
        messagingSenderId: "431149927348",
        appId: "1:431149927348:web:bf11ca32a71424533e40e1"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    const messaging = firebase.messaging();

    messaging.onMessage(function(payload) {
        console.log('Message received. ', payload);
        const notificationTitle = payload.data.title;
        const notificationOptions = {
            body: payload.data.body,
            icon: payload.data.icon,
            data: {
                url: payload.data.click_action
            }
        };

        const notification = new Notification(notificationTitle,notificationOptions);
        notification.onclick = function(event) {
            event.preventDefault();
            window.location.href = notificationOptions.data.url;
        };
    });
</script>
@auth()

    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="notificationModalLabel">Enable Notifications</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close" onclick="dismissNotificationModal()"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img src="{{asset('home/image/notification-stop.svg')}}" alt="Notification Off" class="img-fluid" width="120">
                        <p class="mt-4">
                            It looks like you've blocked notifications! Please enable notifications from your browser settings to stay updated with our latest alerts.
                        </p>
                        <p class="text-muted small">Notifications are essential to keep you informed of important updates.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .modal-dialog-centered {
            animation: slideDown 0.5s ease-in-out; /* Slide down animation */
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>



    <script>
        const dismissedTime = localStorage.getItem('notification-dismissed');
        const oneMonth = 1000 * 60 * 60 * 24 * 30;

        function showNotificationModal() {
            var myModal = new bootstrap.Modal(document.getElementById('notificationModal'), {
                keyboard: false
            });
            myModal.show();
        }
        function dismissNotificationModal() {
            const now = new Date();
            localStorage.setItem('notification-dismissed', now);
        }
        function initFirebaseMessagingRegistration() {
            if (Notification.permission === 'granted') {
                messaging.getToken().then(function(token) {
                    // Send the token to your server for storage
                    axios.post("{{ route('push.store') }}", {
                        _method: "PATCH",
                        token
                    }).then(({data}) => {
                        console.log(data)
                    }).catch(({response:{data}}) => {
                        console.error(data)
                    });
                }).catch(function (err) {
                    console.log(`Token Error :: ${err}`);
                });
            } else if (Notification.permission === 'default') {
                // Ask for permission if it's not yet granted
                messaging.requestPermission().then(function() {
                    return messaging.getToken();
                }).then(function(token) {
                    axios.post("{{ route('push.store') }}", {
                        _method: "PATCH",
                        token
                    }).then(({data}) => {
                        console.log(data)
                    }).catch(({response:{data}}) => {
                        console.error(data)
                    });
                }).catch(function (err) {
                    console.log(`Token Error :: ${err}`);
                });
            } else if (Notification.permission === 'denied') {
                if (!dismissedTime || (new Date() - new Date(dismissedTime) > oneMonth)) {
                    showNotificationModal();
                }
            }
        }

        initFirebaseMessagingRegistration();

    </script>
@endauth
<script src="https://kit.fontawesome.com/ba417b72f4.js" crossorigin="anonymous"></script>
<style>
    .btn-auto {
        padding: 0.5rem 0.5rem;
        font-size: 0.85rem;
        width: auto;
        display: inline-block;
        margin-bottom: 20px;
    }
    body.dark .card {
        background-color: rgb(18, 38, 54);
        color: #ffffff;
    }

    /* Styling for .card-body in dark mode */
    body.dark .card .card-body {
        background-color: rgb(18, 38, 54);
        color: #ffffff;
    }
</style>
<script src="{{asset('dashboard/js/selectize.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('dashboard/css/selectize.bootstrap5.css')}}">
<script>
    $('.selectize').selectize();
    $('.selectizeAdd').selectize({
        create:true,
        showAddOptionOnCreate:true,
        createOnBlur:true,
        highlight:true,
        hideSelected:true
    });
</script>
<style>
    body.dark .selectize-input,.selectize-control.single .selectize-input.input-active  {
        background-color: rgb(18, 38, 54) !important;
        border-color: rgb(18, 38, 54) !important;
        color: #ffffff !important;
        padding: 0.2rem 0.5rem;
        font-size: 0.85rem;
        display: inline-block;
    }
    body.dark .selectize-dropdown .selected {
        background-color:rgb(18, 38, 54);
        color:#fff
    }
    .selectize-input,.selectize-control.single .selectize-input.input-active  {
        padding: 0.2rem 0.5rem;
        font-size: 0.85rem;
        display: inline-block;
    }
    body.dark th{
        color: #ffffff;
    }
    body.dark tr{
        color: #ffffff;
    }
    body.dark .modal-body{
        background-color:rgb(18, 38, 54);
        color:#fff
    }
    body.dark .modal-header{
        background-color:rgb(18, 38, 54);
        color:#fff
    }
    body.dark .title{
        font-size: larger;
        color:#fff
    }
    .modal-content {
        border-radius: 15px;
    }
    body.dark .boxed-check-group .boxed-check .boxed-check-label{
        background-color:rgb(18, 38, 54);
        color:#fff
    }

</style>

@include('noti_js')
{{--<script src="https://unpkg.com/lite-editor@1.6.39/js/lite-editor.min.js"></script>--}}
{{--<link rel="stylesheet" href="https://unpkg.com/lite-editor@1.6.39/css/lite-editor.css">--}}
{{--<script>--}}
{{--    new LiteEditor('.editor',{--}}
{{--        minHeight: 200,--}}
{{--    });--}}
{{--</script>--}}

<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="{{asset('tinymce/tinymce.min.js')}}"></script>

<script>
    tinymce.init({
        selector: ".editor",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table paste",
        ],
        toolbar:
            "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    });
</script>
<style>
    .tox .tox-promotion{
        display: none;
    }
</style>

<link rel="stylesheet" href="http://127.0.0.1:8000/dashboard/css/boxed-check.min.css">
<script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.11/dist/clipboard.min.js"></script>
<script>
    new ClipboardJS('.copy');
</script>
<script>
    var clipboard= new ClipboardJS('.cpy');
    clipboard.on('success', function(e) {
        toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
        toastr.info("Copied");

    });
</script>
<script>
    var clipboard= new ClipboardJS('.cpy-link');
    clipboard.on('success', function(e) {
        toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
        toastr.info("Link copied. Visit your browser and paste it to continue.");

    });
</script>

<style>
    .scrollable-box {
        max-height: 100px; /* Adjust this value as needed */
        overflow-y: auto;  /* Enables vertical scrolling if content exceeds max height */
        padding-right: 10px; /* Optional padding to avoid scrollbar overlap */
    }
</style>
<style>
    body.dark .page-link{
        background-color:rgb(18, 38, 54);
        color: #f0f0f0;
    }
    body.dark .text-muted{
        color: #f0f0f0 !important;
    }
</style>
