import * as Utils from './utils.js'

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
            } else if (object.account.value.length > object.account.maxLength+1 && !object.accountTooltip.isTooltopShow) {
                object.accountTooltip.tooltipShow();
                error++;
            }
            if(object.accountTooltip.isTooltopShow && error===0){
                object.accountTooltip.tooltipHide();
            }
            let error1 = 0;
            if ((object.email.value === null || object.email.value === "") && !object.emailTooltip.isTooltopShow) {
                object.emailTooltip.tooltipShow();
                error1++;
            } else if (object.email.value.length > object.email.maxLength+1 && !object.emailTooltip.isTooltopShow) {
                object.emailTooltip.tooltipShow();
                error1++;
            } else if (!Utils.validateEmail(object.email.value) && !object.emailTooltip.isTooltopShow) {
                object.emailTooltip.tooltipShow();
                error1++;
            }
            if(object.emailTooltip.isTooltopShow && error1===0){
                object.emailTooltip.tooltipHide();
            }
            let error2 = 0;
            if ((object.password.value === null || object.password.value === "") && !object.passwordTooltip.isTooltopShow) {
                object.passwordTooltip.tooltipShow();
                error2++;
            } else if (object.password.value.length < object.password.minLength && !object.passwordTooltip.isTooltopShow) {
                object.passwordTooltip.tooltipShow();
                error2++;
            }
            if(object.passwordTooltip.isTooltopShow && error2===0){
                object.passwordTooltip.tooltipHide();
            }
            let error3 = 0;
            if ((object.repassword.value === null || object.repassword.value === "") && !object.repasswordTooltip.isTooltopShow) {
                object.repasswordTooltip.tooltipShow();
                error3++;
            } else if (object.repassword.value.length < object.repassword.minLength && !object.repasswordTooltip.isTooltopShow) {
                object.repasswordTooltip.tooltipShow();
                error3++;
            } else if (object.password.value !== object.repassword.value && !object.repasswordTooltip.isTooltopShow) {
                object.repasswordTooltip.tooltipShow();
                error3++;
            }
            if(object.repasswordTooltip.isTooltopShow && error3===0){
                object.repasswordTooltip.tooltipHide();
            }
            let error4 = 0;
            if ((object.phone.value === null || object.phone.value === "") && !object.phoneTooltip.isTooltopShow) {
                object.phoneTooltip.tooltipShow();
                error4++;
            } else if (object.phone.value.length < object.phone.minLength && !object.phoneTooltip.isTooltopShow) {
                object.phoneTooltip.tooltipShow();
                error4++;
            } else if (!Utils.validatePhone(object.phone.value) && !object.phoneTooltip.isTooltopShow) {
                object.phoneTooltip.tooltipShow();
                error4++;
            }
            if(object.phoneTooltip.isTooltopShow && error4===0){
                object.phoneTooltip.tooltipHide();
            }
            let error5 = 0;
            let csrf = document.querySelector("#csrf_token");
            if(csrf === null) error5++;
            if(registerEl.dataset.token === undefined) error5++;
            if(error>0) return false;
            if(error1>0) return false;
            if(error2>0) return false;
            if(error3>0) return false;
            if(error4>0) return false;
            if(error5>0) return false;
            let formdata = new FormData();
            formdata.append("token", registerEl.dataset.token);
            formdata.append("username", object.account.value);
            formdata.append("email", object.email.value);
            formdata.append("phone", object.phone.value);
            formdata.append("password",  Utils.encodeContext(object.password.value).compress);
            formdata.append("password_confirmation",  Utils.encodeContext(object.repassword.value).compress);
            fetch("/register", {
                method: 'post',
                body: formdata,
                headers: {
                    'X-CSRF-TOKEN': csrf.value
                },
            }).then(async (res) => {
                //console.log(res);
                let json = await res.json();
                console.log(json);
            });
        };
    }
    return false;
}

function loader() {
    register()
}

document.addEventListener('DOMContentLoaded', loader);
