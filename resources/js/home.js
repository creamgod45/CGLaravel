import './bootstrap';
import './Pusher.js'
import '@fortawesome/fontawesome-free/js/all.js';
import './tooltip.js';
import './lazyImageLoader.js';
import './placerholder.js';
import './menu.js';
import './button.js';
import './notification.js';
import './customTrigger.js';
import './phone.js';
import './popover.js';
import * as floatUI from '@floating-ui/dom'
import * as Utils from './utils.js'

if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark')
} else {
    document.documentElement.classList.remove('dark')
}

// Whenever the user explicitly chooses light mode
if (localStorage.getItem('theme') === undefined) {
    localStorage.theme = 'light'
}



function load6() {
    document.addEventListener("mousemove", function (e) {
        Utils.rotateElement(e, document.querySelector("#_3DModel1"));
        Utils.rotateElement(e, document.querySelector("#_3DModel2"));
    });
}


function load1() {
    const button = document.querySelector('#A');
    const tooltip = document.querySelector('#B');
    if(button !== null && tooltip !== null){
        const cleanup = floatUI.autoUpdate(button, tooltip, () => {

            floatUI.computePosition(button, tooltip, {
                placement: 'top',
                middleware: [
                    floatUI.offset(8),
                    floatUI.flip({
                        crossAxis: true,
                        fallbackPlacements: ['right', 'bottom'],
                        rootBoundary: {
                            x:0,
                            y:80,
                        }
                    }),
                    floatUI.shift({
                        padding: 8
                    }),
                    floatUI.hide({
                        strategy: "referenceHidden",
                        padding: 8,
                        rootBoundary: {
                            x:0,
                            y:80,
                        }
                    })
                ]
            }).then(({x, y, middlewareData}) => {
                //console.log(middlewareData);
                if (middlewareData.hide) {
                    Object.assign(tooltip.style, {
                        visibility: middlewareData.hide.referenceHidden
                            ? 'hidden'
                            : 'visible',
                    });
                }
                Object.assign(tooltip.style, {
                    left: `${x}px`,
                    top: `${y}px`,
                });
                button.onclick = ()=>{
                    if(tooltip.classList.contains('!invisible')) {
                        tooltip.classList.remove('!invisible');
                    }else{
                        tooltip.classList.add('!invisible');
                    }
                };
            });
        });
    }
}

function load2() {
    let formData = new FormData();
    formData.append('a', encodeURIComponent(Utils.encodeContext("test").compress))
    fetch("/lzstring.json", {
        body: formData,
        method: 'POST',
    }).then(async response => {
        if (response.ok) {
            let json = await response.json();
            console.log(json);
        }
    })
}

function load3() {
    axios.get('https://randomuser.me/api/',{
        //URL参數放在params屬性裏面
        params: {
            gender: 'female',
            nat: 'us'
        }
    })
        .then((response) => {
            console.log(response);
            var result = response.data.results[0];
            let name="";
            for (let [key, entry] of Object.entries(result.name)) {
                if(entry !== undefined) {
                    name += entry + " ";
                }
            }
            document.querySelector("#C").innerText = name;
            document.querySelector("#C1").href = `mailto:${result.email}`;
            document.querySelector("#C2").href = `tel:${result.phone}`;
            document.querySelector("#C3").dataset.src = result.picture.large;
        })
        .catch((error) => console.log(error))
}

function loader() {
    load1();
    load2();
    load3();
}

window.addEventListener("resize", ()=>{

});

document.addEventListener("DOMContentLoaded", loader);
