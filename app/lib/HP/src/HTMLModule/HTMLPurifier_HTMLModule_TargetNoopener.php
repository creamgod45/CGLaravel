<?php
namespace App\Lib\HP\src\HTMLModule;

use App\Lib\HP\src\AttrTransform\HTMLPurifier_AttrTransform_TargetNoopener;
use App\Lib\HP\src\HTMLPurifier_HTMLModule;

/**
 * Module adds the target-based noopener attribute transformation to a tags.  It
 * is enabled by HTML.TargetNoopener
 */
class HTMLPurifier_HTMLModule_TargetNoopener extends HTMLPurifier_HTMLModule
{
    /**
     * @type string
     */
    public $name = 'TargetNoopener';

    /**
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     */
    public function setup($config) {
        $a = $this->addBlankElement('a');
        $a->attr_transform_post[] = new HTMLPurifier_AttrTransform_TargetNoopener();
    }
}
