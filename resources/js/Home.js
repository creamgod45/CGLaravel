import * as LZString from "lz-string";
import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';
import {encodeContext} from "@/utils.js";

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

function loader() {

}

window.addEventListener("resize", ()=>{

});

document.addEventListener("DOMContentLoaded", loader);
