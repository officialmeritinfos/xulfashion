<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(getMobileType()->isAndroidOS() || getMobileType()->isDesktop())
    <div class="install-prompt" id="install-prompt">
        <!-- App Icon -->
        <img src="{{asset('home/image/xulfashion_client.png')}}" alt="App Icon">
        <!-- App Info and Ratings -->
        <div class="install-text">
            <strong>{{$siteName}}</strong>
            <div class="stars">
                &#9733; &#9733; &#9733; &#9733; &#9733; <!-- Star ratings -->
            </div>
        </div>
        <!-- Install Button -->
        <button id="install-client-btn" class="install-btn install-client-btn">Get the App</button>
    </div>
@endif
<script>
    // Variable to store the deferred prompt event for the Marketplace
    let deferredPrompt;

    // Register the service worker for the Xulfashion Marketplace (Client PWA)
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw-client.js').then(function(registration) {
            // Once the service worker is ready, cache the start URL dynamically
            navigator.serviceWorker.ready.then(function(activeWorker) {
                const startUrlClient = "{{ route('mobile.marketplace.index') }}"; // Dynamically fetch start URL
                activeWorker.active.postMessage({
                    action: 'cache-start-url',
                    url: startUrlClient
                });
                console.log('Xulfashion Client Service Worker registered and ready with scope:', registration.scope);
            });

            // Check if there's an update to the service worker
            registration.onupdatefound = function () {
                const installingWorker = registration.installing;
                installingWorker.onstatechange = function () {
                    if (installingWorker.state === 'installed') {
                        if (navigator.serviceWorker.controller) {
                            // New update available, show a notification to the user
                            console.log('New update available for the PWA.');
                            showUpdateNotification(); // Notify the user to refresh
                        }
                    }
                };
            };
        }).catch(function(error) {
            console.error('Xulfashion Client Service Worker registration failed:', error);
        });

        // Listen for messages from the service worker about updates
        navigator.serviceWorker.addEventListener('message', function(event) {
            if (event.data && event.data.action === 'reload') {
                // Automatically refresh the page to load the new version
                window.location.reload();
            }
        });
    }

    // Listen for the `beforeinstallprompt` event and store it
    window.addEventListener('beforeinstallprompt', (e) => {
        document.getElementById('install-prompt').style.bottom = '0'; // Show install prompt UI
        console.log('beforeinstallprompt event fired');
        e.preventDefault(); // Prevent the default prompt from showing
        deferredPrompt = e; // Store the event for Marketplace
    });

    // Handle the click event for the Marketplace install button
    document.querySelectorAll('.install-client-btn').forEach((button) => {
        button.addEventListener('click', () => {
            if (deferredPrompt) {
                deferredPrompt.prompt(); // Show the install prompt
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the Marketplace install prompt');
                    } else {
                        console.log('User dismissed the Marketplace install prompt');
                    }
                    deferredPrompt = null; // Reset the prompt so it can’t be used again
                });
            } else {
                console.log('Marketplace install prompt not available');
            }
        });
    });


    // Function to display the update notification
    function showUpdateNotification() {
        const updateBanner = document.createElement('div');
        updateBanner.classList.add('update-banner');
        updateBanner.innerHTML = `
        <div class="alert alert-primary text-center">
            <p>A new version of this app is available.</p>
            <button class="btn btn-primary" id="reload-btn">Install</button>
        </div>
    `;
        document.body.appendChild(updateBanner);

        document.getElementById('reload-btn').addEventListener('click', function () {
            window.location.reload(); // Reload the page to load the new version
        });
    }
</script>

<style>
    .update-banner {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #4B0076;
        padding: 10px;
        z-index: 1000;
        text-align: center;
    }
</style>

<style>
    /* Styling for the install prompt */
    .install-prompt {
        position: fixed;
        bottom: -100px; /* Initially hidden below the viewport */
        left: 0;
        right: 0;
        background-color: #F0F4FF;
        padding: 15px 20px;
        color: #333;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 8px 8px 0 0; /* Rounded corners at the top */
        box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        transition: bottom 0.5s ease-in-out;
    }

    /* App icon styling */
    .install-prompt img {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        margin-right: 15px;
    }

    /* App details section */
    .install-text {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .install-text strong {
        font-size: 18px;
        color: #4a4a4a;
    }

    .install-text .stars {
        color: #FFD700;
    }

    /* "Get the App" button */
    .install-btn {
        color: #fff;
        background-color: #4B0076;
        border: none;
        padding: 10px 20px;
        font-size: 14px;
        border-radius: 25px;
        text-transform: uppercase;
    }

    .install-prompt .stars {
        font-size: 14px;
    }

    .floating-btn {
        position: fixed;
        bottom: 20px;
        left: 20px;
        z-index: 999;
    }

    /* Ensure the instruction box is styled */
    .alert-heading {
        font-size: 18px;
        font-weight: bold;
    }

    .collapse-icon {
        float: right;
        cursor: pointer;
        color: #000;
    }
</style>


