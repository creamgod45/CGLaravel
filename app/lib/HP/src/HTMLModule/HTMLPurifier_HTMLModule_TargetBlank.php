<?php
namespace App\Lib\HP\src\HTMLModule;

use App\Lib\HP\src\AttrTransform\HTMLPurifier_AttrTransform_TargetBlank;
use App\Lib\HP\src\HTMLPurifier_HTMLModule;

/**
 * Module adds the target=blank attribute transformation to a tags.  It
 * is enabled by HTML.TargetBlank
 */
class HTMLPurifier_HTMLModule_TargetBlank extends HTMLPurifier_HTMLModule
{
    /**
     * @type string
     */
    public $name = 'TargetBlank';

    /**
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        $a = $this->addBlankElement('a');
        $a->attr_transform_post[] = new HTMLPurifier_AttrTransform_TargetBlank();
    }
}

// vim: et sw=4 sts=4
