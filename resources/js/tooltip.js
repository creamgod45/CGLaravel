import {generateRandomString, htmldecode} from "@/utils.js";

function tooltip() {
    let tooltips = document.querySelectorAll(".tooltip-gen");

    function getOnmouseenter(direction, tooltip, tooltipEl) {
        return () => {
            let t = document.createElement("div");
            t.classList.add("tooltip");
            t.classList.add(direction);
            if(tooltipEl.dataset.customclass!==undefined){
                console.log(tooltipEl.dataset.customclass)
                let strings = tooltipEl.dataset.customclass.split(" ");
                if (strings.length > 1){
                    for (let string of strings) {
                        t.classList.add(string);
                    }
                }else{
                    t.classList.add(tooltipEl.dataset.customclass);
                }
            }
            let s = generateRandomString(5);
            t.id = s;
            if(tooltipEl.dataset.htmlable !== undefined){
                console.log(tooltipEl.dataset.htmlable);
                if (tooltipEl.dataset.htmlable === "true") {
                    t.innerHTML = tooltip;
                }else{
                    t.innerHTML = htmldecode(tooltip);
                }
            }else{
                t.innerHTML = htmldecode(tooltip);
            }
            tooltipEl.dataset.destory = "#" + s;
            tooltipEl.appendChild(t);
            let tooltipBound = tooltipEl.getBoundingClientRect();
            //let tBound = t.getBoundingClientRect();
            if (direction === "tooltip-top") {
                t.style.bottom = tooltipBound.height + 20 + "px";
                t.style.right = "0";
                //tooltipBound = tooltipEl.getBoundingClientRect(); tBound = t.getBoundingClientRect();
                //t.style.right = (tBound.x-tooltipBound.x)+(tooltipBound.width)+'px';
                //console.log(`bottom: ${t.style.bottom} left: ${t.style.left}`);
            }
            if (direction === "tooltip-left") {
                t.style.right = tooltipBound.width + 20 + "px";
            }
            if (direction === "tooltip-right") {
                t.style.left = tooltipBound.width + 20 + "px";
            }

            if (direction === "tooltip-bottom") {
                t.style.top = tooltipBound.height + 18 + "px";
                t.style.left = "0";
            }
            tooltipEl.isTooltopShow = true;
        }
    }

    function getOnmouseleave(tooltipEl) {
        return () => {
            if (tooltipEl.dataset.destory !== null) {
                let destoryEl = tooltipEl.dataset.destory;
                document.querySelector(destoryEl).remove();
                tooltipEl.dataset.destory = "";
                tooltipEl.isTooltopShow = false;
            }
        };
    }

    for (let tooltipEl of tooltips) {
        let dataset = tooltipEl.dataset;
        if (dataset.tooltip === null) continue;
        if (dataset.direction === null) continue;
        let tooltip = dataset.tooltip;
        let direction = dataset.direction;
        if(tooltipEl.dataset.hoverable !== undefined){
            if (tooltipEl.dataset.hoverable === "false") {

            }else{
                tooltipEl.onmouseenter = getOnmouseenter(direction, tooltip, tooltipEl)
                tooltipEl.onmouseleave = getOnmouseleave(tooltipEl)
            }
        }else{
            tooltipEl.onmouseenter = getOnmouseenter(direction, tooltip, tooltipEl)
            tooltipEl.onmouseleave = getOnmouseleave(tooltipEl)
        }
        tooltipEl.isTooltopShow = false;
        tooltipEl.tooltipShow = getOnmouseenter(direction, tooltip, tooltipEl)
        tooltipEl.tooltipHide = getOnmouseleave(tooltipEl)
    }
}

document.addEventListener('resize', tooltip);
document.addEventListener('DOMContentLoaded', tooltip);
