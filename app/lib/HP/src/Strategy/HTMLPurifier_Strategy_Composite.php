<?php
namespace App\Lib\HP\src\Strategy;

use App\Lib\HP\src\HTMLPurifier_Strategy;

/**
 * Composite strategy that runs multiple strategies on tokens.
 */
abstract class HTMLPurifier_Strategy_Composite extends HTMLPurifier_Strategy
{

    /**
     * List of strategies to run tokens through.
     * @type \App\Lib\HP\src\HTMLPurifier_Strategy[]
     */
    protected $strategies = array();

    /**
     * @param \App\Lib\HP\src\HTMLPurifier_Token[] $tokens
     * @param \App\Lib\HP\src\HTMLPurifier_Config $config
     * @param \App\Lib\HP\src\HTMLPurifier_Context $context
     * @return \App\Lib\HP\src\HTMLPurifier_Token[]
     */
    public function execute($tokens, $config, $context)
    {
        foreach ($this->strategies as $strategy) {
            $tokens = $strategy->execute($tokens, $config, $context);
        }
        return $tokens;
    }
}

// vim: et sw=4 sts=4
