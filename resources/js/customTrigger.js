function customTrigger() {
    var cts = document.querySelectorAll('.ct');
    for (let ct of cts) {
        //console.log(ct)
        if (ct.dataset.fn !== null && ct.dataset.targetget !== null) {
            let target = ct.dataset.target;
            //console.log(target)
            switch (ct.dataset.fn) {
                case 'password-toggle':
                    ct.onclick=()=>{
                        let tel = document.querySelector(target);
                        if (tel !== null) {
                            if (tel.type === "password") {
                                ct.innerHTML="<i class=\"fa-regular fa-eye-slash\"></i>";
                                tel.type = 'text';
                            } else {
                                ct.innerHTML="<i class=\"fa-regular fa-eye\"></i>";
                                tel.type = 'password';
                            }
                        }
                    };
                    break;
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', customTrigger);
