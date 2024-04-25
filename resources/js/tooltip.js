import {generateRandomString, htmldecode} from "@/utils.js";

function tooltip() {
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

document.addEventListener('resize', tooltip);
document.addEventListener('DOMContentLoaded', tooltip);
