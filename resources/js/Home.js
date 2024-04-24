import * as LZString from "lz-string";
import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';
import {func} from "three/addons/nodes/code/FunctionNode.js";

if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark')
} else {
    document.documentElement.classList.remove('dark')
}

let scene, camera, renderer, asset1=null;

function reset(){
    if(asset1!==null){
        scene.remove(asset1.scene);
    }
    scene=null;
    camera=null;
    renderer=null;
    asset1=null;
}

function init() {
    // 創建場景
    scene = new THREE.Scene();

    // 設置相機
    camera = new THREE.PerspectiveCamera(120, 1, 0.1, 1000);
    camera.position.z = 5;
    //camera.position.y += 2;

    // 創建渲染器
    renderer = new THREE.WebGLRenderer({ alpha: true });  // 啟用透明
    renderer.setClearColor(0x000000, 0); // 背景色設為透明
    renderer.setSize(document.querySelector("#_3DModel").clientWidth, document.querySelector("#_3DModel").clientHeight);
    document.querySelector("#_3DModel").innerHTML="";
    document.querySelector("#_3DModel").appendChild(renderer.domElement);

    // 加載GLB模型
    const loader = new GLTFLoader();
    loader.load('/assets/images/welcome_banner2_programming.glb', function(gltf) {
        scene.add(gltf.scene);
        // 初始縮放
        asset1 = gltf;
        //gltf.scene.scale.set(15, 15, 15); // 將模型放大到原始大小的1.5倍
        //document.addEventListener('mousemove', onMouseMove, false);
    }, undefined, function(error) {
        console.error(error);
    });

    // 添加燈光
    const light = new THREE.AmbientLight(0xffffff, 2); // 軟光
    scene.add(light);
}

function onMouseMove(event) {
    // 計算滑鼠位置
    const mouseX = (event.clientX / window.innerWidth) * 2+2;
    const mouseY = -(event.clientY / window.innerHeight) * 2-1;
    console.log(mouseX, mouseY)

    // 根據滑鼠位置平移物件
    if(asset1!==null){
        if(asset1['scene']!==undefined){
            asset1.scene.rotation.x = -mouseY*0.25;
            asset1.scene.rotation.y = mouseX*0.25;
        }
    }
}

function animate() {
    requestAnimationFrame(animate);
    renderer.render(scene, camera);
}


// Whenever the user explicitly chooses light mode
if (localStorage.getItem('theme') === undefined) {
    localStorage.theme = 'light'
}

function encodeContext(data) {
    let hash = "";
    let encodeBase64 = btoa(encodeURIComponent(data));
    let source= encodeBase64;
    //console.log(encodeBase64);
    let length = encodeBase64.length;
    let randomNumbers = generateRandomNumbers(0, length - 1, (length - 1) / 6);
    //console.log(randomNumbers);
    randomNumbers.forEach((value, k) => {
        //console.log(k, value);
        let a = string_move_shift(encodeBase64, k, value);
        encodeBase64 = a.str;
        let index = a.index;
        let shiftIndex = a.shift;
        hash += index + "&" + shiftIndex + "$";
    })
    //console.log(encodeBase64);
    //console.log(hash);
    //console.log(atob(decodeURIComponent(encodeBase64)));
    return {
        source: source,
        hash: hash,
        encode: encodeBase64,
        compress: LZString.compressToUTF16(encodeBase64+"."+hash),
    };
}

function decodeContext(compress) {
    let raw_data = LZString.decompressFromUTF16(compress);
    let strings = raw_data.split('.');
    let data = strings[0];
    let hash = strings[1];
    let hashChunk = hash.split("$");
    let hashChunk2 =[];
    for (let hashChunkElement of hashChunk) {
        let tt = hashChunkElement.split("&");
        hashChunk2[Number.parseInt(tt[0])] = Number.parseInt(tt[1]);
    }
    for (let i = hashChunk2.length-1; i > -1; i--) {
        let a = string_move_shift(data, i, hashChunk2[i]);
        data = a.str;
    }
    //console.log(data);
    //console.log(data === t.source);
    return decodeURIComponent(atob(data));
}

function generateRandomNumbers(rangeStart, rangeEnd, numNumbers) {
    if (numNumbers > (rangeEnd - rangeStart + 1)) {
        throw new Error("Number of requested numbers exceeds range");
    }

    const randomNumbers = [];
    const availableNumbers = Array.from({length: rangeEnd - rangeStart + 1}, (_, i) => i + rangeStart);

    for (let i = 0; i < numNumbers; i++) {
        const randomIndex = Math.floor(Math.random() * availableNumbers.length);
        const randomNumber = availableNumbers[randomIndex];
        randomNumbers.push(randomNumber);

        // Remove the selected number from the available array
        availableNumbers.splice(randomIndex, 1);
    }

    return randomNumbers;
}

function string_move_shift(str, index, shift_index) {
    if (index < 0 || index >= str.length || shift_index < 0 || shift_index >= str.length) {
        throw new Error("Invalid indices");
    }

    const chars = str.split("");
    const temp = chars[index];
    chars[index] = chars[shift_index];
    chars[shift_index] = temp;

    const newStr = chars.join("");
    return {
        str: newStr, index: index, shift: shift_index,
    };
}

function load3() {
    let tooltips = document.querySelectorAll(".tooltip-gen");
    for (let tooltipEl of tooltips) {
        let dataset = tooltipEl.dataset;
        if (dataset.tooltip === null) continue;
        if (dataset.direction === null) continue;
        let tooltip = dataset.tooltip;
        let direction = dataset.direction;
        tooltipEl.onmouseenter = () => {
            let t = document.createElement("div");
            t.classList.add("tooltip");
            t.classList.add(direction);
            let s = generateRandomString(5);
            t.id = s;
            t.innerHTML = htmldecode(tooltip);
            tooltipEl.dataset.destory = "#" + s;
            tooltipEl.appendChild(t);
            let tooltipBound = tooltipEl.getBoundingClientRect();
            let tBound = t.getBoundingClientRect();
            if (direction === "tooltip-left") {
                t.style.right = tooltipBound.width + 16 + "px";
            }
            if (direction === "tooltip-top") {
                t.style.bottom = tooltipBound.height + 8 + "px";
                t.style.right = "0";
                //tooltipBound = tooltipEl.getBoundingClientRect(); tBound = t.getBoundingClientRect();
                //t.style.right = (tBound.x-tooltipBound.x)+(tooltipBound.width)+'px';
                //console.log(`bottom: ${t.style.bottom} left: ${t.style.left}`);
            }
        }
        tooltipEl.onmouseleave = () => {
            if (tooltipEl.dataset.destory !== null) {
                let destoryEl = tooltipEl.dataset.destory;
                document.querySelector(destoryEl).remove();
                tooltipEl.dataset.destory = "";
            }
        }
    }
}

function generateRandomString(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    let result = '';
    const charactersLength = characters.length;
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

function load2() {
    let floatMenuBtns = document.querySelectorAll(".float-menu-btn");
    for (let floatMenuBtn of floatMenuBtns) {
        //floatMenuBtn.onmouseenter = () => {
        //    let target = document.querySelector(floatMenuBtn.dataset.target);
        //    if(target===null) return;
        //    // 一次設置多個樣式
        //    target.style.animationName = "sliderDownLittle";
        //    target.style.animationDuration = "0.5s";
        //    target.style.animationTimingFunction = "linear";
        //    target.style.display = "grid";
        //    target.style.position = "relative";
        //    target.style.zIndex = "0";
        //    target.style.boxShadow = "var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000)";
        //    setTimeout(function () {
        //        target.style.animationName = "";
        //        target.style.animationDuration = "";
        //        target.style.animationTimingFunction = "";
        //        target.style.display = "";
        //        target.style.position = "";
        //        target.style.zIndex = "";
        //        target.style.boxShadow = "";
        //    }, 450);
        //};
        floatMenuBtn.onclick = () => {
            let element = document.querySelector(floatMenuBtn.dataset.target);
            if (element !== null) {
                if (element.classList.contains("active")) {
                    // 如果開啟就關閉
                    element.classList.remove("active");
                    element.classList.add("off");
                    setTimeout(function () {
                        element.classList.remove("off");
                    }, 450);
                } else {
                    //如果關閉就開啟
                    let listpanel = document.querySelectorAll('.float-menu-panel');
                    let s = 0;
                    let count = 0;
                    for (let listpanelElement of listpanel) {
                        if (listpanelElement.classList.contains("active")) {
                            listpanelElement.classList.remove("active");
                            listpanelElement.classList.add("off");
                            let second = Number.parseInt(listpanelElement.dataset.second);
                            s += second / 2;
                            setTimeout(function () {
                                listpanelElement.classList.remove("off");
                            }, second);
                            count++;
                        }
                    }
                    console.log(count);
                    console.log(s);
                    if (count === 0) {
                        console.log(1);
                        element.classList.add("active");
                    } else {
                        console.log(2);
                        let second = Number.parseInt(element.dataset.second) + s;
                        setTimeout(function () {
                            element.classList.remove("off");
                            element.classList.add("active");
                        }, second / 1.2);
                    }
                }
            }
        };
    }
}

function load1() {
    /** First we get all the non-loaded image elements **/
    var lazyImages = document.querySelectorAll(".lazy-loaded-image");
    /** Then we set up a intersection observer watching over those images and whenever any of those becomes visible on the view then replace the placeholder image with actual one, remove the non-loaded class and then unobserve for that element **/
    let lazyImageObserver = new IntersectionObserver(function (entries, observer) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                let lazyImage = entry.target;
                //console.log(entry);
                //console.log(lazyImage);
                lazyImage.style.backgroundImage = `url(${lazyImage.dataset.src})`;
            }
        });
    });

    for (let lazyImage of lazyImages) {
        lazyImageObserver.observe(lazyImage);
    }
}
function load5(){
    let obj = "Web:HTML, CSS3(sass,scss), JS(nodeJs,commonJs, jQuery, AJAX), PHP(8.2~7.0), RWD, 基本程式, 資料庫, API, Websocket, 聊天室(非websocket技術), JWT, 自研框架, 資訊安全防護(IDE: PHPStorm)Android Studio(手機軟體設計) 基本程式, toast, Form, API, 通知, 相機(QRcode), 資料庫,執行緒, 檔案GitC#(.NET Framework, MAUI 8) / C++ / C （Arduino）基本程式Java 執行緒,基本程式,資料庫,介面, APIPython 爬蟲,資料庫,基本程式P.S 基本程式（程式必學技能迴圈,變數,陣列,類型,類別）";
    let t = encodeContext(obj);
    console.log(t.compress);
    console.log(t.compress.length);
    //console.log(t.encode);
    //let a = decodeContext(t.compress);
    //console.log(a);
    let formData = new FormData();
    formData.append('a', t.compress);
    fetch('api/lzstring.json', {
        body: formData,
        method: "POST",
    }).then((response) => {
        if (response.ok) {
            return;
        }
    })
    fetch('api/user', {
        method: "GET",
    }).then((response) => {
        if (response.ok) {
            let promise = response.json();
            promise.then(console.log);
        }
    })
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

function load4(){
    reset();
    init();
    animate();
}

function loader() {
    load1();
    load2();
    load3();
    //load4();
    //load6();
}

window.addEventListener("resize", ()=>{
    load3();
    //load4();
});

document.addEventListener("DOMContentLoaded", loader);

function htmlencode(txt) {
    var div = document.createElement("div");
    div.appendChild(document.createTextNode(txt));
    return div.innerHTML;
}

function htmldecode(txt) {
    var div = document.createElement("div");
    div.innerHTML = txt;
    return div.innerText || div.textContent;
}
