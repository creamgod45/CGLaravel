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

function sendMailVerifyCode(ct, target) {
    ct.onclick = () =>{
        if(ct.dataset.token === null) return false;
        let csrf = document.querySelector("#csrf_token");
        if(csrf === null) return false;
        let formdata = new FormData();
        formdata.append('token', ct.dataset.token);
        fetch('/sendMailVerifyCode', {
                method: "post",
                headers: {
                    'X-CSRF-TOKEN': csrf.value
                },
                body: formdata,
            })
            .then(async (res) => {
                console.log(res);
                let json = await res.json();
                console.log(json);
                let el = document.querySelector(target);
                ct.dataset.token = json.token;
                el.innerText = json.message;
            })
            .catch(console.log);
    };
}

function verifyCode(ct, target) {
    if (ct.dataset.action !== null && ct.dataset.action1 !== null && ct.dataset.action2 !== null &&
        ct.dataset.action3 !== null && ct.dataset.action4 !== null && ct.dataset.token !== null) {
        let actionel= document.querySelector(ct.dataset.action);
        let action1el= document.querySelector(ct.dataset.action1);
        let action2el= document.querySelector(ct.dataset.action2);
        let action3el = document.querySelector(ct.dataset.action3);
        let action4el = document.querySelector(ct.dataset.action4);
        let targetel = document.querySelector(target);
        ct.onclick = ()=>{
            if (targetel.value !== null) {
                if(ct.dataset.token === null) return false;
                let csrf = document.querySelector("#csrf_token");
                if(csrf === null) return false;
                let formdata = new FormData();
                formdata.append("code", targetel.value);
                formdata.append('token', ct.dataset.token);
                fetch('/verifyCode', {
                        method: "post",
                        body: formdata,
                        headers: {
                            'X-CSRF-TOKEN': csrf.value
                        },
                    }
                    )
                    .then(async (res) => {
                        console.log(res);
                        let json = await res.json();
                        console.log(json);
                        if (json.access_token !== null) {
                            var htmlInputElement = document.createElement("input");
                            htmlInputElement.value=json.access_token;
                            htmlInputElement.name="sendMailVerifyCodeToken";
                            htmlInputElement.type="hidden";
                            actionel.innerHTML = "";
                            actionel.append(htmlInputElement);
                            action1el.remove();
                            action2el.remove();
                            action3el.disabled = false;
                            action4el.disabled = false;
                            ct.dataset.token = json.token;
                        }
                    })
                    .catch(console.log);
            }
        };
    }
}

function customTrigger() {
    var cts = document.querySelectorAll('.ct');
    for (let ct of cts) {
        console.log(ct)
        if (ct.dataset.fn !== null && ct.dataset.target !== null) {
            let target = ct.dataset.target;
            console.log(target)
            switch (ct.dataset.fn) {
                case 'password-toggle':
                    password_toggle(ct, target);
                    break;
                case "datalist_selector":
                    datalist_selector(ct, target);
                    break;
                case "sendMailVerifyCode":
                    sendMailVerifyCode(ct, target);
                    break;
                case "verifyCode":
                    verifyCode(ct, target);
                    break;
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', customTrigger);
