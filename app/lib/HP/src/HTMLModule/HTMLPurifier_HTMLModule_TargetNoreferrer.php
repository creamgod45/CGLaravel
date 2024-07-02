<?php
namespace App\Lib\HP\src\HTMLModule;

use App\Lib\HP\src\AttrTransform\HTMLPurifier_AttrTransform_TargetNoreferrer;
use App\Lib\HP\src\HTMLPurifier_HTMLModule;

/**
 * Module adds the target-based noreferrer attribute transformation to a tags.  It
 * is enabled by HTML.TargetNoreferrer
 */
class HTMLPurifier_HTMLModule_TargetNoreferrer extends HTMLPurifier_HTMLModule
{
    /**
     * @type string
     */
    public $name = 'TargetNoreferrer';

    /**
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     */
    public function setup($config) {
        $a = $this->addBlankElement('a');
        $a->attr_transform_post[] = new HTMLPurifier_AttrTransform_TargetNoreferrer();
    }
}
