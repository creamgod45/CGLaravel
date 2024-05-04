const init = new CustomEvent('init', {
    detail: {
        message: "init all components"
    },
    cancelable: false
});
function placerholder(){
    for (let el of document.querySelectorAll('.placeholder')) {
        if (el.dataset.placeholderdelay !== null) {
            setTimeout(()=>{
                el.classList.remove('placeholder');
                el.classList.remove('placeholder-circle');
                el.classList.remove('placeholder-16-9');
                document.dispatchEvent(init);
            },Number.parseInt(el.dataset.placeholderdelay));
        }else{
            setTimeout(()=>{
                el.classList.remove('placeholder');
                el.classList.remove('placeholder-circle');
                el.classList.remove('placeholder-16-9');
                document.dispatchEvent(init);
            },1000);
        }
    }
}
document.addEventListener('DOMContentLoaded', placerholder);
