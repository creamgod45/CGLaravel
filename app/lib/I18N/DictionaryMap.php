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
        $i->setLanguagev2(ELanguageText::menu_WebDesign, "Web Design");
        $i->setLanguagev2(ELanguageText::menu_PromotionalPage, "Promotional page");
        $i->setLanguagev2(ELanguageText::menu_BrandingWebsite, "Branding Website");
        $i->setLanguagev2(ELanguageText::menu_CMS, "CMS (Content Management System)");
        $i->setLanguagev2(ELanguageText::menu_POS, "POS (Point of Sale) Integration");
        $i->setLanguagev2(ELanguageText::menu_ClientCaseStudies, "Client Case Studies");
        $i->setLanguagev2(ELanguageText::menu_VendorOperations, "Vendor Operations");
        $i->setLanguagev2(ELanguageText::menu_SocialMedia, "Social Media");
        $i->setLanguagev2(ELanguageText::menu_facebook, "Facebook");
        $i->setLanguagev2(ELanguageText::menu_X, "X");
        $i->setLanguagev2(ELanguageText::menu_Youtube, "Youtube");
        $i->setLanguagev2(ELanguageText::menu_Instagram, "Instagram");
        $i->setLanguagev2(ELanguageText::menu_resource, "Resource");
        $i->setLanguagev2(ELanguageText::menu_community, "Community");
        $i->setLanguagev2(ELanguageText::menu_Partner, "Partner");
        $i->setLanguagev2(ELanguageText::menu_guide, "Guide");
        $i->setLanguagev2(ELanguageText::menu_WIKI, "WIKI");
        $i->setLanguagev2(ELanguageText::menu_Privacy, "Privacy");
        $i->setLanguagev2(ELanguageText::menu_language, "Language");
        $i->setLanguagev2(ELanguageText::menu_tag_global, "Global");
        $i->setLanguagev2(ELanguageText::menu_tag_Sustainable, "Sustainable");
        $i->setLanguagev2(ELanguageText::menu_membersBtn, "Members");
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
        $i->setLanguagev2(ELanguageText::validator_field_enable, "Enable");
        $i->setLanguagev2(ELanguageText::validator_field_administrator, "Administrator");
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
        $i->setLanguagev2(ELanguageText::login_username_notfound, "Login failed. %validator_field_username% does not exist");
        $i->setLanguagev2(ELanguageText::pagination_firstPage, "First Page");
        $i->setLanguagev2(ELanguageText::pagination_previous, "Previous");
        $i->setLanguagev2(ELanguageText::pagination_next, "Next");
        $i->setLanguagev2(ELanguageText::pagination_lastPage, "Last Page");
        $i->setLanguagev2(ELanguageText::pagination_CurrentPage, "Current page");
        $i->setLanguagev2(ELanguageText::pagination_TotalPages, "Total pages");
        $i->setLanguagev2(ELanguageText::notification_title, "The layout is currently under production");
        $i->setLanguagev2(ELanguageText::notification_description, "Please wait for the page to be published!!");
    }
}
