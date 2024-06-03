
function notification(){
    let nitem = document.querySelectorAll(".notification .item");
    //console.log(nitem);
    for (let ela of nitem) {
        let close = ela.querySelector('.close-btn');
        //console.log(close)
        if(close!==null){
            close.onclick = ()=>{
                ela.classList.add('done');
                ela.classList.add('fadeOut');
                setTimeout(()=>{
                    ela.remove();
                },900);
            };
        }
        let seconds = 4900;
        if (ela.dataset.seconds !== null) {
            seconds = ela.dataset.seconds-100;
        }
        setTimeout(()=>{
            let el = document.querySelector('#'+ela.id);
            if(el!==null){
                el.classList.add('done');
                el.classList.add('fadeOut');
                setTimeout(()=>{
                    el.remove();
                },900);
            }
        }, seconds);
    }
}

document.addEventListener('DOMContentLoaded', notification);
