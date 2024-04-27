function ripple(){
    document.querySelectorAll('.btn-ripple').forEach(button => {
        //button.addEventListener('click', createRipple);
        button.addEventListener('mouseup', createRipple);
    });
    //console.log('ripper')
}
function createRipple(event) {
    //console.log(event)
    const button = event.currentTarget;

    const circle = document.createElement("span");
    let b = button.getBoundingClientRect();
    const diameter = Math.max(button.clientWidth, button.clientHeight);
    const radius = diameter / 2;

    circle.style.width = circle.style.height = `${diameter}px`;
    circle.style.left = `${event.clientX - b.x - radius}px`;
    circle.style.top = `${event.clientY - b.y - radius}px`;
    circle.classList.add("ripple");

    setTimeout(()=>{
        circle.remove();
    }, 600)

    button.appendChild(circle);
}

document.addEventListener('DOMContentLoaded', ripple);
