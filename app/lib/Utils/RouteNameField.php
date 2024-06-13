<?php

namespace App\Lib\Utils;

enum RouteNameField: string
{
    // Page
    case PageHome = 'root.Home';
    case PageDesignComponents = 'root.DesignHTMLComponents';
    case PagePasswordReset = 'root.member.password.reset';
    case PagePasswordResetPost = 'root.member.password.reset.post';
    case PageForgetPassword = 'root.member.password.request';
    case PageForgetPasswordPost = 'root.member.password.request.post';
    case PageEmailVerification = 'root.member.email.verification'; //verification.verify
    case PageEmailReSendMailVerification = 'root.member.email.verification.resend';
    case PageProfile = 'root.member.profile';
    case PageProfilePost = 'root.member.profile.post';
    case PageMembers = 'root.member.list';
    case PageLogout = 'root.member.logout';
    case PageRegister = 'root.member.register';
    case PageRegisterPost = 'root.member.register.post';
    case PageLogin = 'root.member.login';
    case PageLoginPost = 'root.member.login.post';

    // API
    case APIEncodeJson = 'root.api.EncodeJson';
    case APILanguage = 'root.api.Language';
    case APIBrowser = 'root.api.Browser';
    case APIBroadcast = 'root.api.Broadcast';
    case APIHTMLTemplateNotification = 'root.api.HTMLTemplateNotification';
}
