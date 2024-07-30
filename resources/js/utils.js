import * as LZString from "lz-string";

export function generateRandomString(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    let result = '';
    const charactersLength = characters.length;
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

export function encodeContext(data) {
    let hash = "";
    let encodeBase64 = btoa(encodeURIComponent(htmlencode(data)));
    let source= encodeBase64;
    //console.log(encodeBase64);
    let length = encodeBase64.length;
    let randomNumbers = generateRandomNumbers(0, length - 1, (length - 1) / 6);
    //console.log(randomNumbers);
    randomNumbers.forEach((value, k) => {
        //console.log(k, value);
        let a = string_move_shift(encodeBase64, k, value);
        encodeBase64 = a.str;
        let index = a.index;
        let shiftIndex = a.shift;
        hash += index + "&" + shiftIndex + "$";
    })
    //console.log(encodeBase64);
    //console.log(hash);
    //console.log(atob(decodeURIComponent(encodeBase64)));
    return {
        source: source,
        hash: hash,
        encode: encodeBase64,
        compress: LZString.compressToBase64(encodeBase64+"."+hash),
    };
}

export function decodeContext(compress) {
    let raw_data = LZString.decompressFromBase64(compress);
    let strings = raw_data.split('.');
    let data = strings[0];
    let hash = strings[1];
    let hashChunk = hash.split("$");
    let hashChunk2 =[];
    for (let hashChunkElement of hashChunk) {
        let tt = hashChunkElement.split("&");
        hashChunk2[Number.parseInt(tt[0])] = Number.parseInt(tt[1]);
    }
    for (let i = hashChunk2.length-1; i > -1; i--) {
        let a = string_move_shift(data, i, hashChunk2[i]);
        data = a.str;
    }
    //console.log(data);
    //console.log(data === t.source);
    return htmldecode(decodeURIComponent(atob(data)));
}

export function generateRandomNumbers(rangeStart, rangeEnd, numNumbers) {
    if (numNumbers > (rangeEnd - rangeStart + 1)) {
        throw new Error("Number of requested numbers exceeds range");
    }

    const randomNumbers = [];
    const availableNumbers = Array.from({length: rangeEnd - rangeStart + 1}, (_, i) => i + rangeStart);

    for (let i = 0; i < numNumbers; i++) {
        const randomIndex = Math.floor(Math.random() * availableNumbers.length);
        const randomNumber = availableNumbers[randomIndex];
        randomNumbers.push(randomNumber);

        // Remove the selected number from the available array
        availableNumbers.splice(randomIndex, 1);
    }

    return randomNumbers;
}

export function string_move_shift(str, index, shift_index) {
    if (index < 0 || index >= str.length || shift_index < 0 || shift_index >= str.length) {
        throw new Error("Invalid indices");
    }

    const chars = str.split("");
    const temp = chars[index];
    chars[index] = chars[shift_index];
    chars[shift_index] = temp;

    const newStr = chars.join("");
    return {
        str: newStr, index: index, shift: shift_index,
    };
}


export function htmlencode(txt) {
    var div = document.createElement("div");
    div.appendChild(document.createTextNode(txt));
    return div.innerHTML;
}

export function htmldecode(txt) {
    var div = document.createElement("div");
    div.innerHTML = txt;
    return div.innerText || div.textContent;
}

export function rotateElement(event, element) {
    // get mouse position
    const x = event.clientX;
    const y = event.clientY;
    // console.log(x, y)

    // find the middle
    const middleX = window.innerWidth / 2;
    const middleY = window.innerHeight / 2;
    // console.log(middleX, middleY)

    // get offset from middle as a percentage
    // and tone it down a little
    const offsetX = ((x - middleX) / middleX) * 10;
    const offsetY = ((y - middleY) / middleY) * 10;
    // console.log(offsetX, offsetY);

    // set rotation
    element.style.setProperty("--rotateX", offsetX + "deg");
    element.style.setProperty("--rotateY", -1 * offsetY + "deg");
}

export function validateEmail(email) {
    // 定義正則表達式
    var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    // 測試信箱字串是否符合正則表達式
    return regex.test(email);
}

export function validatePhone(phone){
    var regex = /^\d{10,}$/;
    return regex.test(phone);
}


export async function getClientFingerprint() {
    const fingerprintComponents = [];

    // Canvas Fingerprint
    function getCanvasFingerprint() {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        ctx.textBaseline = 'top';
        ctx.font = '14px Arial';
        ctx.fillStyle = '#f60';
        ctx.fillRect(125, 1, 62, 20);
        ctx.fillStyle = '#069';
        ctx.fillText('Hello, world!', 2, 15);
        ctx.fillStyle = 'rgba(102, 204, 0, 0.7)';
        ctx.fillText('Hello, world!', 4, 17);
        return canvas.toDataURL();
    }
    fingerprintComponents.push(getCanvasFingerprint());

    // WebGL Fingerprint
    function getWebGLFingerprint() {
        const canvas = document.createElement('canvas');
        const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
        if (!gl) return null;
        const debugInfo = gl.getExtension('WEBGL_debug_renderer_info');
        return gl.getParameter(debugInfo.UNMASKED_VENDOR_WEBGL) + '~' + gl.getParameter(debugInfo.UNMASKED_RENDERER_WEBGL);
    }
    fingerprintComponents.push(getWebGLFingerprint());

    // ClientRects Fingerprint
    function getClientRectsFingerprint() {
        const div = document.createElement('div');
        div.style.cssText = 'width: 100px; height: 100px; overflow: scroll; position: absolute; top: -9999px;';
        document.body.appendChild(div);
        const rects = div.getClientRects();
        document.body.removeChild(div);
        return JSON.stringify(rects);
    }
    fingerprintComponents.push(getClientRectsFingerprint());

    // Fonts Fingerprint
    function getFontsFingerprint() {
        const fonts = ['Arial', 'Verdana', 'Times New Roman', 'Courier New', 'Courier', 'Helvetica', 'Garamond', 'Georgia', 'Palatino'];
        const detectedFonts = [];
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        ctx.textBaseline = 'top';
        ctx.font = '72px monospace';
        const reference = ctx.measureText('mmmmmmmmmmmmmlli').width;
        fonts.forEach(font => {
            ctx.font = `72px ${font}, monospace`;
            const width = ctx.measureText('mmmmmmmmmmmmmlli').width;
            if (width !== reference) {
                detectedFonts.push(font);
            }
        });
        return detectedFonts.join(',');
    }
    fingerprintComponents.push(getFontsFingerprint());

    // Navigator Fingerprint
    function getNavigatorFingerprint() {
        return JSON.stringify({
            userAgent: navigator.userAgent,
            language: navigator.language,
            platform: navigator.platform,
            hardwareConcurrency: navigator.hardwareConcurrency,
            deviceMemory: navigator.deviceMemory
        });
    }
    fingerprintComponents.push(getNavigatorFingerprint());

    // Timezone Fingerprint
    function getTimezoneFingerprint() {
        return Intl.DateTimeFormat().resolvedOptions().timeZone;
    }
    fingerprintComponents.push(getTimezoneFingerprint());

    // Clipboard Fingerprint
    //async function getClipboardFingerprint() {
    //    try {
    //        const text = await navigator.clipboard.readText();
    //        return text;
    //    } catch (e) {
    //        return '';
    //    }
    //}
    //fingerprintComponents.push(await getClipboardFingerprint());

    // Random Fingerprint
    //function getRandomFingerprint() {
    //    return Math.random().toString(36).substring(2);
    //}
    //fingerprintComponents.push(getRandomFingerprint());

    const fingerprint = fingerprintComponents.join('~');
    return encodeContext(fingerprint)['compress'];
}
