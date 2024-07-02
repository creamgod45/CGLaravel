<?php
namespace App\Lib\HP\src\AttrTransform;

use App\Lib\HP\src\HTMLPurifier_AttrTransform;

/**
 * Implements required attribute stipulation for <script>
 */
class HTMLPurifier_AttrTransform_ScriptRequired extends HTMLPurifier_AttrTransform
{
    /**
     * @param array $attr
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @param \App\Lib\HP\src\HTMLPurifier_Context $context
     * @return array
     */
    public function transform($attr, $config, $context)
    {
        if (!isset($attr['type'])) {
            $attr['type'] = 'text/javascript';
        }
        return $attr;
    }
}

// vim: et sw=4 sts=4
