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

Route::get('/', [InternalController::class,'branding'])->name(RouteNameField::PageHome->value);
Route::get('designcomponents', [InternalController::class,'designComponents'])->name(RouteNameField::PageDesignComponents->value);
Route::post('encode.json', [InternalController::class, 'encodeJson'])->name(RouteNameField::APIEncodeJson->value);
Route::post('broadcast', [InternalController::class, 'broadcast_Notification_Notification']);
Route::post('language', [InternalController::class, 'language'])->name(RouteNameField::APILanguage->value);
//Route::post('user', [InternalController::class, 'user']);
Route::post('browser', [InternalController::class, 'browser'])->name(RouteNameField::APIBrowser->value);
// password reset
Route::get('passwordreset', [MemberController::class, 'passwordreset'])->name(RouteNameField::PagePasswordReset->value);
Route::post('passwordreset', [MemberController::class, 'passwordresetpost'])->name(RouteNameField::PagePasswordResetPost->value);
// forgot password
Route::get('forgot-password',  [MemberController::class, 'forgetpassword'])->name(RouteNameField::PageForgetPassword->value);
Route::post('forget-password', [MemberController::class, 'forgetpasswordpost'])->name('password.email');
// email verify
Route::get('email/verify/{id}/{hash}', [MemberController::class, 'emailVerify'])->name('verification.verify');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('members', [MemberController::class, 'index']);
});

Route::group(["prefix"=>"HTMLTemplate"], function () {
    Route::post('Notification', [ HTMLTemplateController::class, 'Notification' ])->name('HTMLTemplate.Notification');
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [MemberController::class, 'logout'])->name('logout');
    Route::get('resendemail', [MemberController::class, 'resendEmail'])->name('verification.notice');
    // Profile Start
    Route::get('profile', [MemberController::class, 'profile'])->name('member.profile');
    Route::post('profile', [MemberController::class, 'profilepost'])->name('member.profile.post');
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
    Route::get('login', [MemberController::class, 'loginPage'])->name('member.form-login');
    Route::post('login', [MemberController::class, 'login']);
    Route::get('register', [MemberController::class, 'showRegistrationForm'])->name('member.form-register');
    Route::post('register', [MemberController::class, 'register'])->name("member.form-register-post");
});
