<?php

namespace App\Lib\Utils;

enum RouteNameField :string
{
    case PageHome = 'root.Home';
    case PageDesignComponents = 'root.DesignHTMLComponents';
    case PagePasswordReset = 'password.reset';
    case PagePasswordResetPost = 'password.resetpost';
    case PageForgetPassword = 'password.request';
    case APIEncodeJson = 'root.EncodeJson';
    case APILanguage = 'root.Language';
    case APIBrowser = 'root.Browser';
}
