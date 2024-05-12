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
                            setTimeout(() => createRipple(el), 400);
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
                            setTimeout(() => createRipple(el), 400);
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
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', customTrigger);
