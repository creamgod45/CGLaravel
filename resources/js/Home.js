//import * as THREE from 'three';
//import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';
import * as floatUI from '@floating-ui/dom'
import * as Utils from './utils.js'
import {For} from "three/addons/transpiler/AST.js";
//import functionCallNode from "three/addons/nodes/code/FunctionCallNode.js";

if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark')
} else {
    document.documentElement.classList.remove('dark')
}

// Whenever the user explicitly chooses light mode
if (localStorage.getItem('theme') === undefined) {
    localStorage.theme = 'light'
}



function rotateElement(event, element) {
    // get mouse position
    const x = event.clientX;
    const y = event.clientY;
    // console.log(x, y)

    // find the middle
    const middleX = window.innerWidth / 2;
    const middleY = window.innerHeight / 2;
    // console.log(middleX, middleY)

    // get offset from middle as a percentage
    // and tone it down a little
    const offsetX = ((x - middleX) / middleX) * 45;
    const offsetY = ((y - middleY) / middleY) * 45;
    // console.log(offsetX, offsetY);

    // set rotation
    element.style.setProperty("--rotateX", offsetX + "deg");
    element.style.setProperty("--rotateY", -1 * offsetY + "deg");
}

function load6() {
    document.addEventListener("mousemove", function (e) {
        rotateElement(e, document.querySelector("#_3DModel1"));
        rotateElement(e, document.querySelector("#_3DModel2"));
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

function loader() {
    load1();
    load2();
}

window.addEventListener("resize", ()=>{

});

document.addEventListener("DOMContentLoaded", loader);
