import * as Utils from './utils.js';

function password_toggle(ct, target) {
    ct.onclick = () => {
        let tel = document.querySelector(target);
        if (tel !== null) {
            if (tel.type === "password") {
                ct.innerHTML = "<i class=\"fa-regular fa-eye-slash\"></i>";
                tel.type = 'text';
            } else {
                ct.innerHTML = "<i class=\"fa-regular fa-eye\"></i>";
                tel.type = 'password';
            }
        }
    };
}

function datalist_selector(ct, target) {
    let datalist = document.querySelector(target);
    if (datalist !== null) {
        let s = Utils.generateRandomString(5);
        let i = 0;
        let str_arry = [];
        for (let child of datalist.children) {
            let id = `ct_dls_${s}_${i++}`;
            child.id = id;
            str_arry.push(id);
            if (datalist.dataset.index === null) {
                datalist.dataset.index = "-1";
            }
        }
        datalist.dataset.lists = str_arry.join(",");
        let prevfn = () => {
            let index = datalist.dataset.index;
            if (index !== null) {
                if (index === "0") {
                    index = 0;
                }
                let number = Number.parseInt(index);
                if (number !== -1) {
                    if (datalist.dataset.lists !== null) {
                        let lists = datalist.dataset.lists;
                        let strings = lists.split(',');
                        let string = strings[--number];
                        let el = document.querySelector(`#${string}`);
                        if (el !== null) {
                            el.scrollIntoView({behavior: 'smooth', block: 'nearest'});
                            setTimeout(() => createRipple(el.children[0]), 400);
                            datalist.dataset.index = number;
                        }
                    }
                }
            }
        };
        let nextfn = () => {
            let index = datalist.dataset.index;
            if (index !== null) {
                let number = Number.parseInt(index);
                if (number !== datalist.children.length) {
                    if (datalist.dataset.lists !== null) {
                        let lists = datalist.dataset.lists;
                        let strings = lists.split(',');
                        let string = strings[++number];
                        let el = document.querySelector(`#${string}`);
                        if (el !== null) {
                            el.scrollIntoView({behavior: 'smooth', block: 'nearest'});
                            setTimeout(() => createRipple(el.children[0]), 400);
                            datalist.dataset.index = number;
                        }
                    }
                }
            }
        };
        let next = document.querySelector(ct.dataset.next);
        if (next !== null) {
            next.onclick = nextfn;
        }
        let prev = document.querySelector(ct.dataset.prev);
        if (prev !== null) {
            prev.onclick = prevfn;
        }

        datalist.addEventListener("wheel", function (event) {
            if (event.deltaX < 0) {
                console.log('Wheel moved left');
                prevfn();
            } else if (event.deltaX > 0) {
                console.log('Wheel moved right');
                nextfn();
            }
        });
    }
}

function createRipple(el) {
    //console.log(event)
    const button = el;

    const circle = document.createElement("span");
    let b = button.getBoundingClientRect();
    const diameter = Math.max(button.clientWidth, button.clientHeight);
    const radius = diameter / 2;

    circle.style.width = circle.style.height = `${diameter}px`;
    circle.style.left = `0`;
    circle.style.top = `0`;
    circle.classList.add("ripple");

    setTimeout(() => {
        circle.remove();
    }, 600)

    button.appendChild(circle);
}

// 發送信箱驗證碼
function sendMailVerifyCode_profile_email(ct, target) {
    ct.onclick = () =>{
        if(ct.dataset.token === null) return false;
        let csrf = document.querySelector("#csrf_token");
        if(csrf === null) return false;
        let formdata = new FormData();
        formdata.append('token', ct.dataset.token);
        fetch('/profile/email/sendMailVerifyCode', {
                method: "post",
                headers: {
                    'X-CSRF-TOKEN': csrf.value
                },
                body: formdata,
            })
            .then(async (res) => {
                //console.log(res);
                let json = await res.json();
                //console.log(json);
                let el = document.querySelector(target);
                ct.dataset.token = json.token;
                el.innerText = json.message;
            })
            .catch(console.log);
    };
}

// 信箱的驗證碼驗證
function verifyCode_profile_email(ct, target) {
    if (ct.dataset.action !== null && ct.dataset.action1 !== null && ct.dataset.action2 !== null &&
        ct.dataset.action3 !== null && ct.dataset.action4 !== null && ct.dataset.token !== null) {
        ct.onclick = ()=>{
            let actionel= document.querySelector(ct.dataset.action);
            let action1el= document.querySelector(ct.dataset.action1);
            let action2el= document.querySelector(ct.dataset.action2);
            let action3el = document.querySelector(ct.dataset.action3);
            let action4el = document.querySelector(ct.dataset.action4);
            let targetel = document.querySelector(target);
            if (targetel.value === null) return false;
            if (targetel.value === "") return false;
            if (targetel.minLength !== null) {
                if (targetel.value.length < targetel.minLength) {
                    return false;
                }
            }
            if(ct.dataset.token === null) return false;
            let csrf = document.querySelector("#csrf_token");
            if(csrf === null) return false;
            let formdata = new FormData();
            formdata.append("code", targetel.value);
            formdata.append('token', ct.dataset.token);
            fetch('/profile/email/verifyCode', {
                    method: "post",
                    body: formdata,
                    headers: {
                        'X-CSRF-TOKEN': csrf.value
                    },
                }
                )
                .then(async (res) => {
                    //console.log(res);
                    let json = await res.json();
                    //console.log(json);
                    if (res.status === 200) {
                        if (json.access_token !== "") {
                            let htmlInputElement = document.createElement("input");
                            htmlInputElement.value=json.access_token;
                            htmlInputElement.name="sendMailVerifyCodeToken";
                            htmlInputElement.id="sendMailVerifyCodeToken";
                            htmlInputElement.type="hidden";
                            actionel.innerHTML = "";
                            actionel.append(htmlInputElement);
                            action1el.remove();
                            action2el.remove();
                            action3el.disabled = false;
                            action4el.disabled = false;
                            ct.dataset.token = json.token;
                        }
                    }
                })
                .catch(console.log);
        };
    }
}

function newMailVerifyCode_profile_email(ct, target) {
    if(ct.dataset.token !== null && ct.dataset.data !==null && ct.dataset.result !== null){
        ct.onclick = ()=>{
            let targetel = document.querySelector(target);
            let data = document.querySelector(ct.dataset.data);
            if(data.value === null) return false;
            if(data.value === "") return false;
            if (!Utils.validateEmail(data.value)) return false;
            if (data.maxLength !== null) {
                if (data.value.length > data.maxLength) {
                    return false;
                }
            }
            if(ct.dataset.token === "") return false;
            if(ct.dataset.token === null) return false;
            if(ct.dataset.token === undefined) return false;
            let csrf = document.querySelector("#csrf_token");
            if(csrf === null) return false;
            let formdata = new FormData();
            formdata.append("email", data.value);
            formdata.append("token", ct.dataset.token);
            fetch("/profile/email/newMailVerifyCode", {
                method: 'post',
                body: formdata,
                headers: {
                    'X-CSRF-TOKEN': csrf.value
                },
            }).then(async (res) => {
                //console.log(res);
                let json = await res.json();
                ct.dataset.token = json.token;
                targetel.innerText = json.message;
            });
        };
    }
}

function profileUpdateEmail(ct, target) {
    if(ct.dataset.token !== null && ct.dataset.method !==null){
        ct.onclick = ()=>{
            let value1el = document.querySelector(ct.dataset.value1);
            let value2el = document.querySelector(ct.dataset.value2);
            let value3el = document.querySelector(ct.dataset.value3);
            let resultel = document.querySelector(ct.dataset.result);
            let targetel = document.querySelector(target);
            if(value1el.value === null) return false;
            if(value2el.value === null) return false;
            if(value3el.value === null) return false;
            if(value1el.value === "") return false;
            if(value2el.value === "") return false;
            if(value3el.value === "") return false;
            if (value1el.minLength !== null) {
                if (value1el.value.length < value1el.minLength) {
                    return false;
                }
            }
            if(resultel === null) return false;
            if (!Utils.validateEmail(value2el.value)) return false;
            let csrf = document.querySelector("#csrf_token");
            if(csrf === null) return false;
            let formdata = new FormData();
            formdata.append("method", ct.dataset.method);
            formdata.append("token", ct.dataset.token);
            formdata.append("verification", value1el.value);
            formdata.append("sendMailVerifyCodeToken", value3el.value);
            formdata.append("email", value2el.value);
            fetch("/profile", {
                method: 'post',
                body: formdata,
                headers: {
                    'X-CSRF-TOKEN': csrf.value
                },
            }).then(async (res) => {
                //console.log(res);
                let json = await res.json();
                console.log(json);
                resultel.innerText = json.message;
                if(res.status===200){
                    setTimeout(async ()=>{
                        await targetel.hidePopover();
                        await location.reload();
                    },3000)
                }
            });
        };
    }
}

function sendMailVerifyCode_password(ct, target) {
    ct.onclick = ()=>{
        let targetel = document.querySelector(target);
        if(targetel === null) return false;
        let csrf = document.querySelector("#csrf_token");
        if(csrf === null) return false;
        let formdata = new FormData();
        formdata.append('token', ct.dataset.token);
        fetch('/profile/password/sendMailVerifyCode', {
            method: "post",
            headers: {
                'X-CSRF-TOKEN': csrf.value
            },
            body: formdata,
        }).then(async (res) => {
            console.log(res);
            let json = await res.json();
            console.log(json);
            targetel.innerText = json.message;
            ct.dataset.token = json.token;
        });
    };
}

function verifyCode_password(ct, target) {
    if (ct.dataset.action1 !== null && ct.dataset.action2 !== null &&
        ct.dataset.action4 !== null && ct.dataset.action5 !== null &&
        ct.dataset.action3 !== null && ct.dataset.token !== null &&
        ct.dataset.save !== null) {
        ct.onclick = ()=>{
            let save = document.querySelector(ct.dataset.save);
            let action1el= document.querySelector(ct.dataset.action1);
            let action2el= document.querySelector(ct.dataset.action2);
            let action3el = document.querySelector(ct.dataset.action3);
            let action4el = document.querySelector(ct.dataset.action4);
            let targetel = document.querySelector(target);
            if(action1el === null) return false;
            if(action2el === null) return false;
            if(action3el === null) return false;
            if(action4el === null) return false;
            if(save === null) return false;
            if (targetel.value === null) return false;
            if (targetel.value === "") return false;
            if (targetel.minLength !== null) {
                if (targetel.value.length < targetel.minLength) {
                    return false;
                }
            }
            if(ct.dataset.token === null) return false;
            let csrf = document.querySelector("#csrf_token");
            if(csrf === null) return false;
            let formdata = new FormData();
            formdata.append("code", targetel.value);
            formdata.append('token', ct.dataset.token);
            fetch('/profile/password/verifyCode', {
                    method: "post",
                    body: formdata,
                    headers: {
                        'X-CSRF-TOKEN': csrf.value
                    },
                }
            ).then(async (res) => {
                console.log(res);
                let json = await res.json();
                console.log(json);
                if (res.status === 200) {
                    if (json.access_token !== "") {
                        let htmlInputElement = document.createElement("input");
                        htmlInputElement.value=json.access_token;
                        htmlInputElement.name="profile_password_sendMailVerifyCodeToken";
                        htmlInputElement.id="profile_password_sendMailVerifyCodeToken";
                        htmlInputElement.type="hidden";
                        save.innerHTML = "";
                        save.append(htmlInputElement);
                        action1el.disabled = false;
                        action2el.disabled = false;
                        action3el.disabled = false;
                        action4el.remove();
                        ct.dataset.token = json.token;
                    }
                }
            })
            .catch(console.log);
        };
    }
}

function profileUpdatePassword(ct, target) {
    if(ct.dataset.token !== null && ct.dataset.method !==null){
        ct.onclick = ()=>{
            if(ct.dataset.data1 === null) return false;
            if(ct.dataset.data2 === null) return false;
            if(ct.dataset.data3 === null) return false;
            let value1el = document.querySelector(ct.dataset.data1);
            let value2el = document.querySelector(ct.dataset.data2);
            let value3el = document.querySelector(ct.dataset.data3);
            let popoverel = document.querySelector(ct.dataset.popover);
            let result = document.querySelector(ct.dataset.result);
            let targetel = document.querySelector(target);
            if(value1el.value === null) return false;
            if(value2el.value === null) return false;
            if(value3el.value === null) return false;
            if(value1el.value === "") return false;
            if(value2el.value === "") return false;
            if(value3el.value === "") return false;
            let csrf = document.querySelector("#csrf_token");
            if(csrf === null) return false;
            let formdata = new FormData();
            formdata.append("method", ct.dataset.method);
            formdata.append("token", ct.dataset.token);
            formdata.append("sendMailVerifyCodeToken", targetel.value);
            formdata.append("current-ps", Utils.encodeContext(value1el.value).compress);
            formdata.append("password",  Utils.encodeContext(value2el.value).compress);
            formdata.append("password_confirmation",  Utils.encodeContext(value3el.value).compress);
            fetch("/profile", {
                method: 'post',
                body: formdata,
                headers: {
                    'X-CSRF-TOKEN': csrf.value
                },
            }).then(async (res) => {
                //console.log(res);
                let json = await res.json();
                console.log(json);
                let str ="";
                if (json.hasOwnProperty("errors")) {
                    console.log(json.errors);
                    if (typeof json.errors === "object") {
                        str = json.errors.join("\n<br>");
                    }
                }
                result.innerText = json.message+str;
                if(res.status===200){
                    setTimeout(async ()=>{
                        await popoverel.hidePopover();
                        await location.reload();
                    },3000)
                }
            });
        };
    }
}

function test_broadcast(ct, target) {
    ct.onclick = ()=>{
        let formdata = new FormData();
        formdata.append("description", "test btn send");
        formdata.append("title", "test btn send");
        formdata.append("type", "info");
        formdata.append("second", "10000");
        fetch("broadcast", {
            method: 'post',
            body: formdata,
            headers: {
                'X-CSRF-TOKEN': ct.dataset.token
            },
        }).then(async (res) => {
            console.log(res);
        });
    };
}

function customTrigger() {
    var cts = document.querySelectorAll('.ct');
    for (let ct of cts) {
        //console.log(ct)
        if (ct.dataset.fn !== null && ct.dataset.target !== null) {
            let target = ct.dataset.target;
            //console.log(target)
            switch (ct.dataset.fn) {
                case 'password-toggle':
                    password_toggle(ct, target);
                    break;
                case "datalist_selector":
                    datalist_selector(ct, target);
                    break;
                case "profile.email.sendMailVerifyCode":
                    sendMailVerifyCode_profile_email(ct, target);
                    break;
                case "profile.email.verifyCode":
                    verifyCode_profile_email(ct, target);
                    break;
                case "profile.email.newMailVerifyCode":
                    newMailVerifyCode_profile_email(ct, target);
                    break;
                case "profile.password.sendMailVerifyCode":
                    sendMailVerifyCode_password(ct, target);
                    break;
                case "profile.password.verifyCode":
                    verifyCode_password(ct, target);
                    break;
                case "profileUpdateEmail":
                    profileUpdateEmail(ct, target);
                    break;
                case "profileUpdatePassword":
                    profileUpdatePassword(ct, target);
                    break;
                case "test-broadcast":
                    test_broadcast(ct, target);
                    break;
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', customTrigger);
