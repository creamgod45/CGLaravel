import Pusher from 'pusher-js';
import axios from "axios";
import * as Utils from './utils.js';

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;
let pusher = new Pusher('faa244d58f2ef2333cd9', {
    cluster: 'ap1'
});

const HTMLTemplateNotificationLoadedEvent = new CustomEvent('HTMLTemplateNotificationLoadedEvent', {
    detail: {
        message: "API Call HTMLTemplateNotificationLoadedEvent is ready"
    },
    cancelable: false
});
const PusherRenderNotificationEvent = new CustomEvent('PusherRenderNotificationEvent', {
    detail: {
        message: "API Call PusherRenderNotificationEvent is render done"
    },
    cancelable: false
});
let HTMLTemplateNotificationData = "";

axios.post('/HTMLTemplate/Notification', {}, {
    adapter: "fetch"
}).then(async (res) => {
    console.log(res);
    HTMLTemplateNotificationData = res.data;
    document.dispatchEvent(HTMLTemplateNotificationLoadedEvent);
});
document.addEventListener('HTMLTemplateNotificationLoadedEvent', (event) => {
    console.log(event);
    let publicchannel = pusher.subscribe('Notification');

    function HTMLFormater(msg) {
        let temp = HTMLTemplateNotificationData;
        temp = temp.replaceAll("%id%", "N" + Utils.generateRandomString(10));
        temp = temp.replaceAll("%type%", msg.type);
        temp = temp.replaceAll("%title%", msg.title);
        temp = temp.replaceAll("%description%", msg.description);
        return temp.replaceAll("%second%", msg.second);
    }

    publicchannel.bind('Notification', function (msg, title, type, second) {
        console.log(msg);
        let notificationParents = document.querySelectorAll('.notification .item');
        if(notificationParents.length <= 0) {
            let notificationParent = document.querySelector('.notification');
            notificationParent.innerHTML = HTMLFormater(msg);
        }else{
            let notificationParent = notificationParents[notificationParents.length-1];
            if(notificationParent !== null){
                notificationParent.insertAdjacentHTML("afterend", HTMLFormater(msg)) ;
            }
        }
        document.dispatchEvent(PusherRenderNotificationEvent);
    });
});
