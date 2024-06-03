<?php

use App\Events\YourEvent;
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
    return view('branding', Controller::baseControllerInit($request)->toArrayable());
})->name('home');

Route::get('/designcomponents', function (Request $request) {
    return view('designcomponents', Controller::baseControllerInit($request)->toArrayable());
})->name('designcomponents');

Route::post('lzstring.json', function (Request $request){
    $decodeContext = Utilsv2::decodeContext($request["a"]);
    return response()->json(['message' => 'Data received successfully', 'raw'=> $decodeContext]);
});

Route::post('broadcast', function (Request $request){
    $options = array(
        'cluster' => env('PUSHER_APP_CLUSTER'),
        'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
        env('PUSHER_APP_KEY'),
        env('PUSHER_APP_SECRET'),
        env('PUSHER_APP_ID'),
        $options
    );

    $data['message'] = 'hello world';
    $pusher->trigger('my-channel', 'my-event', $data);

    event(new YourEvent($request['message']));
    broadcast(new YourEvent($request['message']))->toOthers();
    return response()->json(['message' => 'Data received successfully', 'raw'=> $request['message']]);
});

Route::post('language', function (Request $request){
    if(empty($request->all())){
        return response()->json(['message' => 'Get Language', 'lang' => $_COOKIE["lang"] ?? ELanguageCode::en_US->name]);
    } elseif (ELanguageCode::isVaild($request['lang'])) {
        $cookie_expire = time() + (24 * 60 * 60);
        $cookie_path = "/";
        $secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
        $httponly = true;
        setrawcookie('lang', $request['lang'], [
            'expires' => $cookie_expire,
            'path' => $cookie_path,
            'secure' => $secure,
            'httponly' => $httponly
        ]);
        return response()->json(['message' => 'Data received successfully', 'lang' => $request['lang']]);
    } else {
        return response()->json(['message' => 'Error'], ResponseHTTP::HTTP_BAD_REQUEST);
    }
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('members', [MemberController::class, 'index']);
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
    Route::get('register', [MemberController::class, 'showRegistrationForm'])->name('member.form-register');
    Route::post('register', [MemberController::class, 'register'])->name("member.form-register-post");
});
