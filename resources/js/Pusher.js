import Pusher from 'pusher-js';

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;
let pusher = new Pusher('faa244d58f2ef2333cd9', {
    cluster: 'ap1'
});
let publicchannel = pusher.subscribe('public');
publicchannel.bind('chat', function (msg) {
    console.log("Your Event: ",msg);
});

let channel = pusher.subscribe('my-channel');
channel.bind('my-event', function(data) {
    console.log("Post Request vanilla $pusher->trigger: ", data);
});
