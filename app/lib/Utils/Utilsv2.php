<?php /** @noinspection ALL */

namespace App\Lib\Utils;

use App\Lib\I18N\ELanguageCode;
use App\Lib\I18N\I18N;
use Illuminate\Http\Request;

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




}
