<?php

namespace App\Lib\Utils;

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
}
