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
        $i->setLanguagev2(ELanguageText::validator_field_username, "Account");
        $i->setLanguagev2(ELanguageText::validator_field_email, "Email");
        $i->setLanguagev2(ELanguageText::validator_field_password, "Password");
        $i->setLanguagev2(ELanguageText::validator_field_passwordConfirmed, "Confirm Password");
        $i->setLanguagev2(ELanguageText::validator_field_phone, "Phone");
        $i->setLanguagev2(ELanguageText::validator_required, "The :attribute field is required.");
        $i->setLanguagev2(ELanguageText::validator_string, "The :attribute field must be a string.");
        $i->setLanguagev2(ELanguageText::validator_min, "The :attribute field must be at least :min characters.");
        $i->setLanguagev2(ELanguageText::validator_max, "The :attribute field must be at most :max characters.");
        $i->setLanguagev2(ELanguageText::validator_confirmed, "The :attribute and %validator_field_passwordConfirmed% does not match.");
        $i->setLanguagev2(ELanguageText::validator_unique, "The :attribute has already used.");
        $i->setLanguagev2(ELanguageText::register_title, "Register");
        $i->setLanguagev2(ELanguageText::register_btn, "Submit");
        $i->setLanguagev2(ELanguageText::login_title, "Login");
        $i->setLanguagev2(ELanguageText::login_btn, "Submit");
        $i->setLanguagev2(ELanguageText::login_faild, "Login Faild. Maybe is wrong %validator_field_username% or %validator_field_password%");
        $i->setLanguagev2(ELanguageText::logout_title, "Logout");
        $i->setLanguagev2(ELanguageText::logout_context, "The page will redirect after %s% seconds logging out!!Click to go");
    }
}
