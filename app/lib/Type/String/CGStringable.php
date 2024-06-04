<?php

namespace App\Lib\Type\String;

use Exception;
use Psy\Util\Json;

class CGStringable
{
    private $string;
    /**
     * @throws Exception
     */
    public function __construct(mixed $variable)
    {
        if (is_array($variable)) {
            $this->string = Json::encode($variable);
        } elseif (is_object($variable)) {
            $this->string = serialize($variable);
        }elseif (is_bool($variable)) {
            if($variable){
                $this->string = 'true';
            }else{
                $this->string = 'false';
            }
        } elseif (is_numeric($variable)) {
            $this->string = (string) $variable;
        }  elseif (is_double($variable)) {
            $this->string = (string) $variable;
        } elseif (is_float($variable)) {
            $this->string = (string) $variable;
        } elseif(is_string($variable)) {
            $this->string = $variable;
        } else {
            throw new Exception("Not supported converter Stringable variable", 0);
        }
    }

    public function toString(){
        return $this->string;
    }

    public function toCGString(): CGString
    {
        return new CGString($this->string);
    }

    public function __toString(): string
    {
        return $this->string;
    }
}
