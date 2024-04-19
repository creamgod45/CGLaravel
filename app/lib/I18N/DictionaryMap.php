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
        $i->setLanguagev2(ELanguageText::placeholder_memberHelloText, "Hello, %name%!");
        $i->setLanguagev2(ELanguageText::menu_frontpage, "Home");
        $i->setLanguagev2(ELanguageText::menu_product, "Products");
        $i->setLanguagev2(ELanguageText::menu_information, "Information");
        $i->setLanguagev2(ELanguageText::menu_cloudComputing, "Cloud Computing");
        $i->setLanguagev2(ELanguageText::menu_googleCloud, "Google Cloud");
        $i->setLanguagev2(ELanguageText::menu_aws, "AWS");
        $i->setLanguagev2(ELanguageText::menu_MicrosoftAzure, "Microsoft Azure");
        $i->setLanguagev2(ELanguageText::menu_facebook, "Facebook");
        $i->setLanguagev2(ELanguageText::welcome_title_tooltip, "Network Center Service Provider");
        $i->setLanguagev2(ELanguageText::welcome_title, "CGCenter %NCSP%");
        $i->setLanguagev2(ELanguageText::welcome_description, "Start your digital transformation journey");
        $i->setLanguagev2(ELanguageText::welcome_test, "testText %test%");
        $i->setLanguagev2(ELanguageText::welcome_test_placeholder, "placeholder here");
    }
}
