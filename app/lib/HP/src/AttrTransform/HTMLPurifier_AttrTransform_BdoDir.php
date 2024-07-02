<?php
namespace App\Lib\HP\src\AttrTransform;

// this MUST be placed in post, as it assumes that any value in dir is valid
use App\Lib\HP\src\HTMLPurifier_AttrTransform;

/**
 * Post-trasnform that ensures that bdo tags have the dir attribute set.
 */
class HTMLPurifier_AttrTransform_BdoDir extends HTMLPurifier_AttrTransform
{

    /**
     * @param array $attr
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @param \App\Lib\HP\src\HTMLPurifier_Context $context
     * @return array
     */
    public function transform($attr, $config, $context)
    {
        if (isset($attr['dir'])) {
            return $attr;
        }
        $attr['dir'] = $config->get('Attr.DefaultTextDir');
        return $attr;
    }
}

// vim: et sw=4 sts=4
