<?php
namespace App\Lib\HP\src\AttrTransform;

// must be called POST validation
use App\Lib\HP\src\HTMLPurifier_AttrTransform;

/**
 * Adds rel="noreferrer" to any links which target a different window
 * than the current one.  This is used to prevent malicious websites
 * from silently replacing the original window, which could be used
 * to do phishing.
 * This transform is controlled by %HTML.TargetNoreferrer.
 */
class HTMLPurifier_AttrTransform_TargetNoreferrer extends HTMLPurifier_AttrTransform
{
    /**
     * @param array $attr
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @param \App\Lib\HP\src\HTMLPurifier_Context $context
     * @return array
     */
    public function transform($attr, $config, $context)
    {
        if (isset($attr['rel'])) {
            $rels = explode(' ', $attr['rel']);
        } else {
            $rels = array();
        }
        if (isset($attr['target']) && !in_array('noreferrer', $rels)) {
            $rels[] = 'noreferrer';
        }
        if (!empty($rels) || isset($attr['rel'])) {
            $attr['rel'] = implode(' ', $rels);
        }

        return $attr;
    }
}

