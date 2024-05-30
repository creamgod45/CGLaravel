import * as Utils from './utils.js'
import {acos} from "three/nodes";

function register(){
    let registerEl = document.querySelector(".register");
    if(registerEl!==null){
        let children = registerEl.children;
        console.log(children);
        let object = {
            account: children[2].children[1],
            accountTooltip: children[2],
            email: children[3].children[1],
            emailTooltip: children[3],
            password: children[4].children[1],
            passwordTooltip: children[4],
            repassword: children[5].children[1],
            repasswordTooltip: children[5],
            phone: children[6].children[1],
            phoneTooltip: children[6],
            submit: children[7],
        };
        console.log(object);

        object.submit.onclick = ()=>{
            let error = 0;
            if ((object.account.value === null || object.account.value === "") && !object.accountTooltip.isTooltopShow) {
                object.accountTooltip.tooltipShow();
                error++;
            }
            if (object.account.value.length > object.account.maxLength+1 && !object.accountTooltip.isTooltopShow) {
                object.accountTooltip.tooltipShow();
                error++;
            }
            if(object.accountTooltip.isTooltopShow && error===0){
                object.accountTooltip.tooltipHide();
            }
            if ((object.email.value === null || object.email.value === "") && !object.emailTooltip.isTooltopShow) {
                object.emailTooltip.tooltipShow();
                error++;
            }
            if (object.email.value.length > object.email.maxLength+1 && !object.emailTooltip.isTooltopShow) {
                object.emailTooltip.tooltipShow();
                error++;
            }
            if(object.emailTooltip.isTooltopShow && error===0){
                object.emailTooltip.tooltipHide();
            }
            if ((object.password.value === null || object.password.value === "") && !object.passwordTooltip.isTooltopShow) {
                object.passwordTooltip.tooltipShow();
                error++;
            }
            if (object.password.value.length < object.password.minLength && !object.passwordTooltip.isTooltopShow) {
                object.passwordTooltip.tooltipShow();
                error++;
            }
            if(object.passwordTooltip.isTooltopShow && error===0){
                object.passwordTooltip.tooltipHide();
            }
            if ((object.repassword.value === null || object.repassword.value === "") && !object.repasswordTooltip.isTooltopShow) {
                object.repasswordTooltip.tooltipShow();
                error++;
            }
            if (object.repassword.value.length < object.repassword.minLength && !object.repasswordTooltip.isTooltopShow) {
                object.repasswordTooltip.tooltipShow();
                error++;
            }
            if (object.password.value !== object.repassword.value && !object.repasswordTooltip.isTooltopShow) {
                object.repasswordTooltip.tooltipShow();
                error++;
            }
            if(object.repasswordTooltip.isTooltopShow && error===0){
                object.repasswordTooltip.tooltipHide();
            }
            if ((object.phone.value === null || object.phone.value === "") && !object.phoneTooltip.isTooltopShow) {
                object.phoneTooltip.tooltipShow();
                error++;
            }
            if (object.phone.value.length < object.phone.minLength && !object.phoneTooltip.isTooltopShow) {
                object.phoneTooltip.tooltipShow();
                error++;
            }
            if(object.phoneTooltip.isTooltopShow && error===0){
                object.phoneTooltip.tooltipHide();
            }
            if (!Utils.validateEmail(object.email.value) && !object.emailTooltip.isTooltopShow) {
                object.emailTooltip.tooltipShow();
                error++;
            }
            if(object.emailTooltip.isTooltopShow && error===0){
                object.emailTooltip.tooltipHide();
            }
            let csrf = document.querySelector("#csrf_token");
            if(csrf === null) error++;
            if(registerEl.dataset.token) error++;
            if(error>0) return false;
            let formdata = new FormData();
            formdata.append("token", registerEl.dataset.token);
            formdata.append("username", object.account.value);
            formdata.append("email", object.email.value);
            formdata.append("phone", object.phone.value);
            formdata.append("password",  Utils.encodeContext(object.password.value).compress);
            formdata.append("password_confirmation",  Utils.encodeContext(object.repassword.value).compress);
        };
    }
    return false;
}

function loader() {
    register()
}

document.addEventListener('DOMContentLoaded', loader);
