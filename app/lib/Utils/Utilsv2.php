<?php /** @noinspection ALL */

namespace App\Lib\Utils;

use LZCompressor\LZString;

class Utilsv2
{
    public static function is_BigNumber($va): bool
    {
        // 使用 bcmath 函數庫
        if (bccomp($va, 2147483647) > 0) {
            return true;
        }
        return false;
    }

    /**
     * 目前可以驗證正確的幾千幾百幾十幾 但是沒有判斷單位前後順序的程序
     * @param $str
     * @return bool
     */
    public static function chineseNumberVaild($str): bool
    {
        //dump("-----------------------------開始-----------------------------");
        $strarr = mb_str_split($str);
        $arr=[];
        //dump($strarr);
        $numbers=['零','一','二','三','四','五','六','七','八','九','十'];
        $units=['十','百','千','萬','億','兆','京'];
        $mode=0;
        foreach ($strarr as $index => $v){
            //dump('$v = '.$v);
            if($index===0){
                //dump("第一位");
                foreach ($numbers as $number) {
                    if($v === $number){
                        $arr [] = true;
                        if($number === $numbers[10]){ //十
                            $mode=2;
                        }else{
                            $mode=1;
                        }
                        continue 2;
                    }
                }
                $arr[]=false;
            }elseif($mode===0){
                //dump("數字驗證");
                foreach (array_slice($numbers, 1) as $number) {
                    if($v === $number){
                        $mode=1;
                        $arr [] = true;
                        continue 2;
                    }
                }
                $mode=1;
                $arr[]=false;
            }elseif($mode===1){
                //dump("單位驗證");
                foreach ($units as $unit) {
                    if($v === $unit){
                        if($unit===$units[1]){
                            $mode=3;
                        }elseif($unit===$units[0]){
                            $mode=2;
                        }elseif($unit===$units[2]){
                            $mode=4;
                        }else{
                            $mode=0;
                        }
                        $arr [] = true;
                        continue 2;
                    }
                }
                $mode=0;
                $arr[]=false;
            }elseif($mode===2){
                //dump("十位數驗證");
                // 1~9
                foreach (array_slice($numbers, 1, 9) as $number) {
                    if($v === $number){
                        //dump("數字");
                        $mode=1;
                        $arr [] = true;
                        continue 2;
                    }
                }
                foreach ($units as $unit) {
                    if($v === $unit){
                        //dump("單位");
                        $mode=0;
                        $arr [] = true;
                        continue 2;
                    }
                }
                $mode=0;
                $arr[]=false;
            }elseif($mode===3){
                //dump("百位數驗證");
                //if(in_array($number,$strarr[$index+1]))
                // 1~9
                foreach (array_slice($numbers, 0,10) as $number) {
                    if($v === $number){
                        //dump("數字");
                        if($v===$numbers[0]){
                            $mode=5;
                        }else{
                            $mode=1;
                        }
                        $arr [] = true;
                        continue 2;
                    }
                }
                foreach ($units as $unit) {
                    if($v === $unit){
                        //dump("單位");
                        $mode=0;
                        $arr [] = true;
                        continue 2;
                    }
                }
                $mode=0;
                $arr[]=false;
            }elseif($mode===4){
                //dump("千位數驗證");
                // 1~9
                foreach (array_slice($numbers, 0,10) as $number) {
                    if($v === $number){
                        //dump("數字");
                        if($v===$numbers[0]){
                            $mode=5;
                        }else{
                            $mode=1;
                        }
                        $arr [] = true;
                        continue 2;
                    }
                }
                $mode=0;
                $arr[]=false;
            }elseif($mode===5){
                //dump("可以有零的位數 0~9 數驗證");
                //dump(array_slice($numbers, 0,9));
                if($strarr[$index+1]===$units[1]){
                    $mode=6;
                    $arr [] = false;
                    continue;
                }
                foreach (array_slice($numbers, 0,9) as $number) {
                    if($v === $number){
                        //dump("數字");
                        $mode=1;
                        $arr [] = true;
                        continue 2;
                    }
                }
            }
        }
        //dump($arr);
        //dump("-----------------------------結束-----------------------------");
        if(in_array(false, $arr)) return false;
        return true;
    }

    public static function generateRandomString($length) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $result = '';
        $charactersLength = strlen($characters);
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[rand(0, $charactersLength - 1)];
        }
        return $result;
    }

    public static function encodeContext($data) {
        $hash = "";
        $encodeBase64 = base64_encode(urlencode(htmlspecialchars($data)));
        $source = $encodeBase64;
        $length = strlen($encodeBase64);
        $randomNumbers = self::generateRandomNumbers(0, $length - 1, intval(($length - 1) / 6));
        foreach ($randomNumbers as $k => $value) {
            list($str, $index, $shiftIndex) = self::string_move_shift($encodeBase64, $k, $value);
            $encodeBase64 = $str;
            $hash .= $index . "&" . $shiftIndex . "$";
        }
        $compress = LZString::compressToBase64($encodeBase64 . "." . $hash);
        return [
            'source' => $source,
            'hash' => $hash,
            'encode' => $encodeBase64,
            'compress' => $compress
        ];
    }

    public static function decodeContext($compress) {
        $raw_data = LZString::decompressFromBase64($compress);
        $strings = explode('.', $raw_data);
        $data = $strings[0];
        $hash = $strings[1];
        $hashChunks = explode("$", $hash);
        $hashChunk2 = [];
        foreach ($hashChunks as $hashChunkElement) {
            if($hashChunkElement !== ""){
                $tt = explode("&", $hashChunkElement);
                //debugbar()->info($tt);
                $hashChunk2[intval($tt[0])] = intval($tt[1]);
            }
        }
        for ($i = count($hashChunk2) - 1; $i > -1; $i--) {
            $str = self::string_move_shift($data, $i, $hashChunk2[$i]);
            $data = $str[0];
        }
        return htmlspecialchars_decode(urldecode(base64_decode($data)));
    }

    public static function generateRandomNumbers($rangeStart, $rangeEnd, $numNumbers) {
        if ($numNumbers > ($rangeEnd - $rangeStart + 1)) {
            throw new Exception("Number of requested numbers exceeds range");
        }
        $randomNumbers = [];
        $availableNumbers = range($rangeStart, $rangeEnd);
        for ($i = 0; $i < $numNumbers; $i++) {
            $randomIndex = rand(0, count($availableNumbers) - 1);
            $randomNumber = $availableNumbers[$randomIndex];
            $randomNumbers[] = $randomNumber;
            array_splice($availableNumbers, $randomIndex, 1);
        }
        return $randomNumbers;
    }

    public static function string_move_shift($str, $index, $shift_index) {
        if ($index < 0 || $index >= strlen($str) || $shift_index < 0 || $shift_index >= strlen($str)) {
            throw new Exception("Invalid indices");
        }
        $chars = str_split($str);
        $temp = $chars[$index];
        $chars[$index] = $chars[$shift_index];
        $chars[$shift_index] = $temp;
        $newStr = implode("", $chars);
        return [$newStr, $index, $shift_index];
    }



}
