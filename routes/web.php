<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\MemberController;
use App\Http\Middleware\EMiddleWareAliases;
use App\Lib\I18N\ELanguageCode;
use App\Lib\Utils\Utilsv2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response as ResponseHTTP;

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

Route::get('/', function (Request $request) {
    return view('branding', Controller::baseControllerInit($request));
})->name('home');

Route::get('/branding', function (Request $request) {
    return view('welcome', Controller::baseControllerInit($request));
})->name('branding');

Route::post('lzstring.json', function (Request $request){
    $decodeContext = Utilsv2::decodeContext($request["a"]);
    return response()->json(['message' => 'Data received successfully', 'raw'=> $decodeContext]);
});

Route::post('language', function (Request $request){
    if (ELanguageCode::isVaild($request['lang'])) {
        $_COOKIE['lang'] = $request['lang'];
        setrawcookie('lang', $request['lang'], time() + (86400 * 30), "/");
        return response()->json(['message' => 'Data received successfully']);
    }
    return response()->json(['message' => 'Error'], ResponseHTTP::HTTP_BAD_REQUEST);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('members', [MemberController::class, 'index']);
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [MemberController::class, 'logout'])->name('logout');
    Route::get('resendemail', [MemberController::class, 'resendEmail'])->name('verification.notice');
});

// password reset
Route::get('passwordreset', [MemberController::class, 'passwordreset'])->name('password.reset');
Route::post('passwordreset', [MemberController::class, 'passwordresetpost'])->name('password.resetpost');

// forgot password
Route::get('forgot-password',  [MemberController::class, 'forgetpassword'])->name('password.request');
Route::post('forget-password', [MemberController::class, 'forgetpasswordpost'])->name('password.email');

// email verify
Route::get('/email/verify/{id}/{hash}', [MemberController::class, 'emailVerify'])->name('verification.verify');

Route::middleware(EMiddleWareAliases::guest->name)->group(function () {
    Route::get('login', [MemberController::class, 'loginPage'])->name('login');
    Route::post('login', [MemberController::class, 'login']);
    Route::get('register', [MemberController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [MemberController::class, 'register']);
});
