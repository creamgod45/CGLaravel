import './Pusher.js'
import '@fortawesome/fontawesome-free/js/all.js';
import './tooltip.js';
import './lazyImageLoader.js';
import './placerholder.js';
import './menu.js';
import './button.js';
import './notification.js';
import './customTrigger.js';
import './popover.js';
import * as floatUI from '@floating-ui/dom'
import * as Utils from './utils.js'
import axios from "axios";

Utils.getClientFingerprint().then(fingerprint => {
    let flag = 0;
    let id = setInterval(()=>{
        let afn= axios.post("/hello", {
            ID: fingerprint
        }, {
            adapter: "fetch"
        }).then((response) => {
            if (response.data.message === "ok") {
                location.assign('/');
                clearInterval(id);
            }
        });
    }, 1000);
});


function load1() {
    let _3DModel = document.querySelector("._3DModel");
    document.addEventListener("mousemove", function (e) {
        if (_3DModel !== null) {
            Utils.rotateElement(e, _3DModel);
        }
    });
}

function load2() {
    let hero = document.querySelector("#hero");
    let herob = hero.getBoundingClientRect();
    let screenWidth, screenHeight, smallerSize;

    const Z_RANGE = 100; // How deep is your love
    const Z_VELOCITY = -0.0055; // How fast
    const STARS_COUNT = 2000; // How many

    const setSizes = () => {
        screenWidth = herob.width;
        screenHeight = herob.height;
        smallerSize = screenWidth > screenHeight ? screenHeight : screenWidth;
    }
    setSizes();

    const HOLE = {
        x: screenWidth / 2,
        y: screenHeight / 2,
        r: smallerSize / 4
    };

    class Star {
        constructor() {
            this.reset();
        }
        reset() {
            this.x = 1 - Math.random() * 2;
            this.y = 1 - Math.random() * 2;
            this.z = Math.random() * -Z_RANGE;
            this.xPos = 0;
            this.yPos = 0;
            this.angle = 0.001;
        };
        getPosition() {
            this.x = this.x * Math.cos(this.angle) - this.y * Math.sin(this.angle);
            this.y = this.y * Math.cos(this.angle) + this.x * Math.sin(this.angle);
            this.z += Z_VELOCITY;

            this.xPos =
                screenHeight / screenWidth * screenWidth * this.x / this.z +
                screenWidth / 2;
            this.yPos = screenHeight * this.y / this.z + screenHeight / 2;

            // Detect collision with black hole
            if (Math.sqrt((this.xPos-HOLE.x)*(this.xPos-HOLE.x) + (this.yPos-HOLE.y)*(this.yPos-HOLE.y)) <= HOLE.r || this.z >= Z_RANGE) this.reset();
        };
        draw() {
            const size = 3 - -this.z / 2;

            ctx.globalAlpha = (Z_RANGE + this.z) / (Z_RANGE * 2);
            ctx.fillStyle = "white";
            ctx.fillRect(this.xPos, this.yPos, size, size);
            ctx.globalAlpha = 1;
        };
    }
    const stars = new Array(STARS_COUNT);

    for (let i = 0; i < STARS_COUNT; i++) stars[i] = new Star();

    const canvas = document.createElement("canvas");
    canvas.classList.add('frontmask');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    if (hero !== null) {
        hero.appendChild(canvas);
    }
    const ctx = canvas.getContext("2d");

    const animate = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        ctx.beginPath();
        ctx.fillStyle = "white";
        stars.forEach(star => {
            star.getPosition();
            star.draw();
        });
        ctx.fill();

        requestAnimationFrame(animate);
    }
    window.addEventListener('resize', e => {
        setSizes();
        HOLE.r = smallerSize / 4;
        HOLE.x = screenWidth / 2;
        HOLE.y = screenHeight / 2;
    });
    animate();
}

function loader() {
    load1();
    load2();
}

document.addEventListener('DOMContentLoaded', loader);
