<?php
namespace App\Lib\HP\src\URIScheme;

use App\Lib\HP\src\HTMLPurifier_URIScheme;

/**
 * Validates nntp (Network News Transfer Protocol) as defined by generic RFC 1738
 */
class HTMLPurifier_URIScheme_nntp extends HTMLPurifier_URIScheme
{
    /**
     * @type int
     */
    public $default_port = 119;

    /**
     * @type bool
     */
    public $browsable = false;

    /**
     * @param \App\Lib\HP\src\HTMLPurifier_URI $uri
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @param \App\Lib\HP\src\HTMLPurifier_Context $context
     * @return bool
     */
    public function doValidate(&$uri, $config, $context)
    {
        $uri->userinfo = null;
        $uri->query = null;
        return true;
    }
}

// vim: et sw=4 sts=4
