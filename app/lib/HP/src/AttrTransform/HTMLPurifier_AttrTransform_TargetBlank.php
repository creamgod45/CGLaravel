<?php
namespace App\Lib\HP\src\AttrTransform;

// must be called POST validation
use App\Lib\HP\src\HTMLPurifier_AttrTransform;
use App\Lib\HP\src\HTMLPurifier_URIParser;

/**
 * Adds target="blank" to all outbound links.  This transform is
 * only attached if Attr.TargetBlank is TRUE.  This works regardless
 * of whether or not Attr.AllowedFrameTargets
 */
class HTMLPurifier_AttrTransform_TargetBlank extends HTMLPurifier_AttrTransform
{
    /**
     * @type HTMLPurifier_URIParser
     */
    private $parser;

    public function __construct()
    {
        $this->parser = new HTMLPurifier_URIParser();
    }

    /**
     * @param array $attr
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @param \App\Lib\HP\src\HTMLPurifier_Context $context
     * @return array
     */
    public function transform($attr, $config, $context)
    {
        if (!isset($attr['href'])) {
            return $attr;
        }

        // XXX Kind of inefficient
        $url = $this->parser->parse($attr['href']);
        $scheme = $url->getSchemeObj($config, $context);

        if ($scheme->browsable && !$url->isBenign($config, $context)) {
            $attr['target'] = '_blank';
        }
        return $attr;
    }
}

// vim: et sw=4 sts=4
