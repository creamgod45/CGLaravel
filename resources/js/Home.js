if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark')
} else {
    document.documentElement.classList.remove('dark')
}

// Whenever the user explicitly chooses light mode
if (localStorage.getItem('theme') === undefined) {
    localStorage.theme = 'light'
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
                            s += second/2;
                            setTimeout(function(){
                                listpanelElement.classList.remove("off");
                            },second);
                            count++;
                        }
                    }
                    console.log(count);
                    console.log(s);
                    if(count===0){
                        console.log(1);
                        element.classList.add("active");
                    }else{
                        console.log(2);
                        let second = Number.parseInt(element.dataset.second)+s;
                        setTimeout(function(){
                            element.classList.remove("off");
                            element.classList.add("active");
                        },second/1.2);
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

function loader() {
    load1();
    load2();
}

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
