<?php

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
}
