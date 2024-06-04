import Pusher from 'pusher-js';

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;
let pusher = new Pusher('faa244d58f2ef2333cd9', {
    cluster: 'ap1'
});
let publicchannel = pusher.subscribe('Notification');
publicchannel.bind('Notification', function (msg) {
    console.log("Your Event: ",msg);
});
