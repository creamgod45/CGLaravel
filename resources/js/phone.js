import intlTelInput from "intl-tel-input";

let zh_tw;
import('intl-tel-input/build/js/i18n/zh_TW/index.mjs').then(module => {
    zh_tw = module.default;
}).catch(error => console.error('Failed to load zh_TW localization', error));

let zh_cn;
import('intl-tel-input/build/js/i18n/zh/index.mjs').then(module => {
    zh_cn = module.default;
}).catch(error => console.error('Failed to load zh_cn localization', error));

let en;
import('intl-tel-input/build/js/i18n/en/index.mjs').then(module => {
    en = module.default;
}).catch(error => console.error('Failed to load en localization', error));

console.log(navigator.language);
function phone() {
    let tels = document.querySelectorAll('.ITI');
    const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
    for (let tel of tels) {
        let lang;
        switch (navigator.language) {
            case 'zh-TW': lang = zh_tw; break;
            case 'zh-CN': lang = zh_cn; break;
            default: lang = en; break;
        }
        let iti = intlTelInput(tel,{
            CountrySearch: true,
            showSelectedDialCode: true,
            strictMode: true,
            useFullscreenPopup: true,
            i18n: lang,
            initialCountry: "auto",
            utilsScript: "iti_utils.js",
            hiddenInput: function(telInputName) {
                return {
                    phone: "phone_full",
                    country: "country_code"
                };
            },
            geoIpLookup: callback => {
                fetch("https://ipapi.co/json")
                    .then(res => res.json())
                    .then(data => callback(data.country_code))
                    .catch(() => callback("us"));
            },
        });
        const reset = () => {
            console.log('reset')
            let btn = document.querySelector(tel.dataset.btn);
            let msg = document.querySelector(tel.dataset.msg);
            if (btn !== null && msg !==null) {
                msg.innerText="";
                msg.classList.add('hidden');
            }
        };
        if (tel.dataset.btn !== null) {
            let btn = document.querySelector(tel.dataset.btn);
            let msg = document.querySelector(tel.dataset.msg);
            let ok = tel.dataset.true;
            let fail = tel.dataset.false;
            if (btn !== null && msg !==null&&ok !== null && fail !== null) {
                //console.log('ok');
                btn.onclick = ()=>{
                    //console.log('onclick');
                    reset();
                    if (!tel.value.trim()) {
                        msg.innerText = fail;
                        msg.classList.remove('hidden');
                        return false;
                    } else if (iti.isValidNumber()) {
                        msg.innerText = ok;
                        msg.classList.remove("hidden");
                    } else {
                        const errorCode = iti.getValidationError();
                        //console.log(errorCode);
                        msg.innerText = errorMap[errorCode] || "Invalid number";
                        msg.classList.remove('hidden');
                    }
                };
                tel.onchange = reset;
                tel.keyup = reset;
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', phone)
