<?php
namespace App\Lib\HP\src\DefinitionCache;

use App\Lib\HP\src\HTMLPurifier_DefinitionCache;

/**
 * Null cache object to use when no caching is on.
 */
class HTMLPurifier_DefinitionCache_Null extends HTMLPurifier_DefinitionCache
{

    /**
     * @param \App\Lib\HP\src\HTMLPurifier_Definition $def
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @return bool
     */
    public function add($def, $config)
    {
        return false;
    }

    /**
     * @param \App\Lib\HP\src\HTMLPurifier_Definition $def
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @return bool
     */
    public function set($def, $config)
    {
        return false;
    }

    /**
     * @param \App\Lib\HP\src\HTMLPurifier_Definition $def
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @return bool
     */
    public function replace($def, $config)
    {
        return false;
    }

    /**
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @return bool
     */
    public function remove($config)
    {
        return false;
    }

    /**
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @return bool
     */
    public function get($config)
    {
        return false;
    }

    /**
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @return bool
     */
    public function flush($config)
    {
        return false;
    }

    /**
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @return bool
     */
    public function cleanup($config)
    {
        return false;
    }
}

// vim: et sw=4 sts=4
