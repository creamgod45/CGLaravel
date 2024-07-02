<?php
namespace App\Lib\HP\src\AttrTransform;

use App\Lib\HP\src\HTMLPurifier_AttrTransform;

/**
 * Sets height/width defaults for <textarea>
 */
class HTMLPurifier_AttrTransform_Textarea extends HTMLPurifier_AttrTransform
{
    /**
     * @param array $attr
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @param \App\Lib\HP\src\HTMLPurifier_Context $context
     * @return array
     */
    public function transform($attr, $config, $context)
    {
        // Calculated from Firefox
        if (!isset($attr['cols'])) {
            $attr['cols'] = '22';
        }
        if (!isset($attr['rows'])) {
            $attr['rows'] = '3';
        }
        return $attr;
    }
}

// vim: et sw=4 sts=4
