<?php
namespace App\Lib\HP\src\AttrDef\HTML;

use App\Lib\HP\src\HTMLPurifier_AttrDef;

/**
 * Validates a boolean attribute
 */
class HTMLPurifier_AttrDef_HTML_Bool extends HTMLPurifier_AttrDef
{

    /**
     * @type string
     */
    protected $name;

    /**
     * @type bool
     */
    public $minimized = true;

    /**
     * @param bool|string $name
     */
    public function __construct($name = false)
    {
        $this->name = $name;
    }

    /**
     * @param string $string
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @param \App\Lib\HP\src\HTMLPurifier_Context $context
     * @return bool|string
     */
    public function validate($string, $config, $context)
    {
        return $this->name;
    }

    /**
     * @param string $string Name of attribute
     * @return HTMLPurifier_AttrDef_HTML_Bool
     */
    public function make($string)
    {
        return new HTMLPurifier_AttrDef_HTML_Bool($string);
    }
}

// vim: et sw=4 sts=4
