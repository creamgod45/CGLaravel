<?php
namespace App\Lib\HP\src\AttrDef\HTML;

use App\Lib\HP\src\AttrDef\HTMLPurifier_AttrDef_Enum;
use App\Lib\HP\src\HTMLPurifier_AttrDef;

class HTMLPurifier_AttrDef_HTML_ContentEditable extends HTMLPurifier_AttrDef
{
    public function validate($string, $config, $context)
    {
        $allowed = array('false');
        if ($config->get('HTML.Trusted')) {
            $allowed = array('', 'true', 'false');
        }

        $enum = new HTMLPurifier_AttrDef_Enum($allowed);

        return $enum->validate($string, $config, $context);
    }
}
