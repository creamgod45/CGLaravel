<?php

use App\Http\Controllers\HTMLTemplateController;
use App\Http\Controllers\InternalController;
use App\Http\Controllers\MemberController;
use App\Http\Middleware\EMiddleWareAliases;
use App\Lib\Utils\RouteNameField;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('hello', [InternalController::class, 'getClientID'])->name(RouteNameField::PageGetClientID->value);
Route::post('hello', [InternalController::class, 'getClientIDPost'])->name(RouteNameField::PageGetClientIDPost->value);
Route::middleware("checkClientID")->group(function () {
    Route::get('/', [InternalController::class, 'branding'])->name(RouteNameField::PageHome->value);
    Route::get('designcomponents', [InternalController::class,'designComponents'])->name(RouteNameField::PageDesignComponents->value);
    Route::post('encode.json', [InternalController::class, 'encodeJson'])->name(RouteNameField::APIEncodeJson->value);
    Route::post('broadcast', [InternalController::class, 'broadcast_Notification_Notification'])->name(RouteNameField::APIBroadcast->value);
    Route::post('language', [InternalController::class, 'language'])->name(RouteNameField::APILanguage->value);
    //Route::post('user', [InternalController::class, 'user']);
    Route::post('browser', [InternalController::class, 'browser'])->name(RouteNameField::APIBrowser->value);
    // password reset
    Route::get('passwordreset', [MemberController::class, 'passwordReset'])->name(RouteNameField::PagePasswordReset->value);
    Route::post('passwordreset', [MemberController::class, 'passwordResetPost'])->name(RouteNameField::PagePasswordResetPost->value);
    // forgot password
    Route::get('forgot-password',  [MemberController::class, 'forgetPassword'])->name(RouteNameField::PageForgetPassword->value);
    Route::post('forget-password', [MemberController::class, 'forgetPasswordPost'])->name(RouteNameField::PageForgetPasswordPost->value);
    // email verify
    Route::get('email/verify/{id}/{hash}', [MemberController::class, 'emailVerify'])->name(RouteNameField::PageEmailVerification->value);

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('members', [MemberController::class, 'index'])->name(RouteNameField::PageMembers->value);
    });

    Route::group(["prefix"=>"HTMLTemplate"], function () {
        Route::post('Notification', [ HTMLTemplateController::class, 'Notification' ])->name(RouteNameField::APIHTMLTemplateNotification->value);
    });

    Route::middleware('auth')->group(function () {
        Route::get('logout', [MemberController::class, 'logout'])->name(RouteNameField::PageLogout->value);
        Route::get('resendemail', [MemberController::class, 'resendEmail'])->name(RouteNameField::PageEmailReSendMailVerification->value);
        // Profile Start
        Route::get('profile', [MemberController::class, 'profile'])->name(RouteNameField::PageProfile->value);
        Route::post('profile', [MemberController::class, 'profilePost'])->name(RouteNameField::PageProfilePost->value);
        Route::group(['prefix' => 'profile'], function () {
            Route::group(['prefix' => 'email'], function () {
                Route::post('sendMailVerifyCode', [MemberController::class, 'sendMailVerifyCode_profile_email']);
                Route::post('verifyCode', [MemberController::class, 'verifyCode_profile_email']);
                Route::post('newMailVerifyCode', [MemberController::class, 'newMailVerifyCode_profile_email']);
            });
            Route::group(['prefix' => 'password'], function () {
                Route::post('sendMailVerifyCode', [MemberController::class, 'sendMailVerifyCode_profile_password']);
                Route::post('verifyCode', [MemberController::class, 'verifyCode_profile_password']);
            });
        });
        // Profile End
    });

    Route::middleware(EMiddleWareAliases::guest->name)->group(function () {
        Route::get('login', [MemberController::class, 'loginPage'])->name(RouteNameField::PageLogin->value);
        Route::post('login', [MemberController::class, 'login'])->name(RouteNameField::PageLoginPost->value);
        Route::get('register', [MemberController::class, 'showRegistrationForm'])->name(RouteNameField::PageRegister->value);
        Route::post('register', [MemberController::class, 'register'])->name(RouteNameField::PageRegisterPost->value);
    });
});
