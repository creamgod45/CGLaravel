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
        $i->setLanguage(ELanguageText::placeholder_memberHelloText, "Hello, %name%!");
        $i->setLanguage(ELanguageText::menu_frontpage, "Home");
        $i->setLanguage(ELanguageText::menu_product, "Products");
        $i->setLanguage(ELanguageText::menu_information, "Information");
        $i->setLanguage(ELanguageText::menu_cloudComputing, "Cloud Computing");
        $i->setLanguage(ELanguageText::menu_googleCloud, "Google Cloud");
        $i->setLanguage(ELanguageText::menu_aws, "AWS");
        $i->setLanguage(ELanguageText::menu_MicrosoftAzure, "Microsoft Azure");
        $i->setLanguage(ELanguageText::menu_facebook, "Facebook");
        $i->setLanguage(ELanguageText::welcome_title, "CGCenter Network Center Service Provider");
        $i->setLanguage(ELanguageText::welcome_description, "We provide professional services if you need them!!");
    }
}
