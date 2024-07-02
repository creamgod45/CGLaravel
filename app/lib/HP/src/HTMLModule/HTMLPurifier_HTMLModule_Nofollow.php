<?php
namespace App\Lib\HP\src\HTMLModule;

use App\Lib\HP\src\AttrTransform\HTMLPurifier_AttrTransform_Nofollow;
use App\Lib\HP\src\HTMLPurifier_HTMLModule;

/**
 * Module adds the nofollow attribute transformation to a tags.  It
 * is enabled by HTML.Nofollow
 */
class HTMLPurifier_HTMLModule_Nofollow extends HTMLPurifier_HTMLModule
{

    /**
     * @type string
     */
    public $name = 'Nofollow';

    /**
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        $a = $this->addBlankElement('a');
        $a->attr_transform_post[] = new HTMLPurifier_AttrTransform_Nofollow();
    }
}

// vim: et sw=4 sts=4
