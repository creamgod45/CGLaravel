<?php
namespace App\Lib\HP\src\URIFilter;

use App\Lib\HP\src\HTMLPurifier_URIFilter;

class HTMLPurifier_URIFilter_DisableResources extends HTMLPurifier_URIFilter
{
    /**
     * @type string
     */
    public $name = 'DisableResources';

    /**
     * @param \App\Lib\HP\src\HTMLPurifier_URI $uri
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @param \App\Lib\HP\src\HTMLPurifier_Context $context
     * @return bool
     */
    public function filter(&$uri, $config, $context)
    {
        return !$context->get('EmbeddedURI', true);
    }
}

// vim: et sw=4 sts=4
