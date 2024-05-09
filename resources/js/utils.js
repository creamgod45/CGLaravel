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
