<?php
namespace App\Lib\HP\src\AttrDef;

use App\Lib\HP\src\HTMLPurifier_AttrDef;

/**
 * Validates arbitrary text according to the HTML spec.
 */
class HTMLPurifier_AttrDef_Text extends HTMLPurifier_AttrDef
{

    /**
     * @param string $string
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @param \App\Lib\HP\src\HTMLPurifier_Context $context
     * @return bool|string
     */
    public function validate($string, $config, $context)
    {
        return $this->parseCDATA($string);
    }
}

// vim: et sw=4 sts=4
