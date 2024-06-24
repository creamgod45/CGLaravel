let Flag_floatMenuPendingQueueing=false;
let floatMenuPendingQueueList= [];
function menu() {
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
            if(Flag_floatMenuPendingQueueing){
                floatMenuPendingQueueList.push(floatMenuBtn);
                console.log(floatMenuPendingQueueList);
                return;
            }
            Flag_floatMenuPendingQueueing = true;
            let element = document.querySelector(floatMenuBtn.dataset.target);
            if (element !== null) {
                if (element.classList.contains("active")) {
                    // 如果開啟就關閉
                    element.classList.remove("active");
                    element.classList.add("off");
                    setTimeout(function () {
                        Flag_floatMenuPendingQueueing = false;
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
                    //console.log(count);
                    //console.log(s);
                    if (count === 0) {
                        //console.log(1);
                        element.classList.add("active");
                        Flag_floatMenuPendingQueueing = false;
                    } else {
                        //console.log(2);
                        let second = Number.parseInt(element.dataset.second) + s;
                        setTimeout(function () {
                            element.classList.remove("off");
                            element.classList.add("active");
                            Flag_floatMenuPendingQueueing = false;
                        }, second / 1.2);
                    }
                }
            }
        };
        setInterval(()=>{
            if(Flag_floatMenuPendingQueueing === false){
                if(floatMenuPendingQueueList.length === 0) return;
                for (let e of floatMenuPendingQueueList) {
                    e.onclick();
                    if(floatMenuPendingQueueList.length>1){
                        floatMenuPendingQueueList = floatMenuPendingQueueList.splice(0, 1);
                    }else{
                        floatMenuPendingQueueList=[];
                    }
                    break;
                }
                //console.log(floatMenuPendingQueueList);
            }
        }, 500);
    }
}
document.addEventListener('DOMContentLoaded', menu);
