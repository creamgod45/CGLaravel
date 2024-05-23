<?php

namespace App\Lib\Utils;

enum EValidatorType
{
    case LOGIN;
    case REGISTER;
    case FORGOTPASSWORD;
    case RESETPASSWORD;
    case RESETPASSWORDPOST;
    case ANIMALCREATE;
    case PROFILEGENERAL;
    case PROFILEUPDATEEMAIL;
    case PROFILEUPDATEPASSWORD;
    case SENDMAILVERIFYCODE;
    case VERIFYCODE;
    case NEWMAILVERIFYCODE;
    case NULL;
}
