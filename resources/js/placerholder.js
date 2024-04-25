const init = new CustomEvent('init', {
    detail: {
        message: "init all components"
    },
    cancelable: false
});
function placerholder(){
    for (let el of document.querySelectorAll('.placeholder')) {
        setTimeout(()=>{
            el.classList.remove('placeholder');
            document.dispatchEvent(init);
        },1000);
    }
}
document.addEventListener('DOMContentLoaded', placerholder);
