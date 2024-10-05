importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyAu-UlGhH7XukmLzt6FozR1HfBOofrv1bc",
    projectId: "nextropay-testing",
    messagingSenderId: "431149927348",
    appId: "1:431149927348:web:bf11ca32a71424533e40e1"
});

const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
    console.log('Handling background message: ', payload);

    const title = payload.data.title;
    const options = {
        body: payload.data.body,
        icon: payload.data.icon,
        data: {
            url: payload.data.click_action
        }
    };

    return self.registration.showNotification(title, options);
});

self.addEventListener('notificationclick', function(event) {
    event.data.close();
    // Open the specified URL when the user clicks on the notification
    event.waitUntil(
        clients.openWindow(event.data.data.url)
    );
});
