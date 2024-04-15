<?php

namespace App\Lib\I18N;

class DictionaryMap
{
    /**
     * @param I18N $i18N
     */
    public function __construct(I18N &$i18N)
    {
        $i = &$i18N;
        $i->setLanguage(ELanguageText::placeholder_memberHelloText,
            "Hello, %name%!");
    }
}
