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