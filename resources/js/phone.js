import intlTelInput from "intl-tel-input";
import zh_tw from "./intl-tel-input/i18n/zh_tw/index.mjs";
//console.log(zh_tw);
import zh_cn from "./intl-tel-input/i18n/zh_tw/index.mjs";
//console.log(zh_cn);
import en from "./intl-tel-input/i18n/en/index.mjs";
//console.log(en);

let lang;

function phone() {
    let tels = document.querySelectorAll('.ITI');
    const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
    for (let tel of tels) {
        let iti = intlTelInput(tel,{
            CountrySearch: true,
            showSelectedDialCode: true,
            strictMode: true,
            useFullscreenPopup: true,
            i18n: lang,
            initialCountry: "auto",
            utilsScript: "iti_utils.js",
            separateDialCode: true,
            customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                return "e.g. " + selectedCountryPlaceholder;
            },
            geoIpLookup: callback => {
                fetch("https://ipapi.co/json")
                    .then(res => res.json())
                    .then(data => callback(data.country_code))
                    .catch(() => callback("us"));
            },
        });
        const reset = (line) => {
            console.log(`reset line:${line}`)
            let btn = document.querySelector(tel.dataset.btn);
            let msg = document.querySelector(tel.dataset.msg);
            if (msg !==null) {
                msg.innerText="";
                msg.classList.add('hidden');
            }
        };
        if (tel.dataset.autotrigger !== undefined && tel.dataset.autotrigger !== null){
            if(tel.dataset.autotrigger === "true"){
                tel.onchange = () => {
                    let msg = document.querySelector(tel.dataset.msg);
                    let ok = tel.dataset.true;
                    let fail = tel.dataset.false;
                    if (msg !==null&&ok !== null && fail !== null) {
                        reset(50);
                        if (!tel.value.trim()) {
                            msg.innerText = fail;
                            msg.classList.remove('hidden');
                            return false;
                        } else if (iti.isValidNumber()) {
                            msg.innerText = ok;
                            msg.classList.remove("hidden");
                            console.log(iti);
                            let namedItem = tel.parentElement.children.namedItem('dialCode');
                            if (namedItem === null) {
                                tel.insertAdjacentHTML("afterend", `<input type='hidden' name='dialCode' value="${iti.selectedCountryData.dialCode}">`);
                            }else{
                                namedItem.value = iti.selectedCountryData.dialCode;
                            }
                        } else {
                            const errorCode = iti.getValidationError();
                            //console.log(errorCode);
                            msg.innerText = errorMap[errorCode] || "Invalid number";
                            msg.classList.remove('hidden');
                        }
                    }
                };
            }
        }
        if (tel.dataset.btn !== null) {
            let btn = document.querySelector(tel.dataset.btn);
            let msg = document.querySelector(tel.dataset.msg);
            let ok = tel.dataset.true;
            let fail = tel.dataset.false;
            if (btn !== null && msg !==null&&ok !== null && fail !== null) {
                //console.log('ok');
                btn.onclick = ()=>{
                    //console.log('onclick');
                    reset(84);
                    if (!tel.value.trim()) {
                        msg.innerText = fail;
                        msg.classList.remove('hidden');
                        return false;
                    } else if (iti.isValidNumber()) {
                        msg.innerText = ok;
                        msg.classList.remove("hidden");
                        console.log(iti);
                        let namedItem = tel.parentElement.children.namedItem('dialCode');
                        if (namedItem === null) {
                            tel.insertAdjacentHTML("afterend", `<input type='hidden' name='dialCode' value="${iti.selectedCountryData.dialCode}">`);
                        }else{
                            namedItem.value = iti.selectedCountryData.dialCode;
                        }
                    } else {
                        const errorCode = iti.getValidationError();
                        //console.log(errorCode);
                        msg.innerText = errorMap[errorCode] || "Invalid number";
                        msg.classList.remove('hidden');
                    }
                };
                tel.onchange = () => reset(106);
                tel.keyup = ()=> reset(107);
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', async () => {
    await fetch('language', {
        method: 'post'
    }).then(async (res) => {
        if (res.ok) {
            let json = await res.json();
            //console.log(json);
            switch (json.lang) {
                case 'zh_TW': lang = zh_tw; break;
                case 'zh_CN': lang = zh_cn; break;
                default: lang = en; break;
            }
        }else await console.log(res);
    }).catch((err)=>{
        console.log(err);
        lang=en;
    });
    //console.log(lang);
    await phone();
})
