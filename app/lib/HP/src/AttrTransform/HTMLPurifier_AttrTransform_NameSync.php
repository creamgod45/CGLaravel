<?php
namespace App\Lib\HP\src\AttrTransform;

use App\Lib\HP\src\AttrDef\HTML\HTMLPurifier_AttrDef_HTML_ID;
use App\Lib\HP\src\HTMLPurifier_AttrTransform;

/**
 * Post-transform that performs validation to the name attribute; if
 * it is present with an equivalent id attribute, it is passed through;
 * otherwise validation is performed.
 */
class HTMLPurifier_AttrTransform_NameSync extends HTMLPurifier_AttrTransform
{

    /**
     * @type HTMLPurifier_AttrDef_HTML_ID
     */
    public $idDef;

    public function __construct()
    {
        $this->idDef = new HTMLPurifier_AttrDef_HTML_ID();
    }

    /**
     * @param array $attr
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @param \App\Lib\HP\src\HTMLPurifier_Context $context
     * @return array
     */
    public function transform($attr, $config, $context)
    {
        if (!isset($attr['name'])) {
            return $attr;
        }
        $name = $attr['name'];
        if (isset($attr['id']) && $attr['id'] === $name) {
            return $attr;
        }
        $result = $this->idDef->validate($name, $config, $context);
        if ($result === false) {
            unset($attr['name']);
        } else {
            $attr['name'] = $result;
        }
        return $attr;
    }
}

// vim: et sw=4 sts=4
