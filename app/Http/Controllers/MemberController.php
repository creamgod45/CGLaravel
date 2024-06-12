<?php /** @noinspection DuplicatedCode */

namespace App\Http\Controllers;

use App\Events\UserNotification;
use App\Lib\I18N\ELanguageText;
use App\Lib\I18N\I18N;
use App\Lib\Server\CSRF;
use App\Lib\Utils\ENotificationType;
use App\Lib\Utils\EValidatorType;
use App\Lib\Utils\RouteNameField;
use App\Lib\Utils\Utils;
use App\Lib\Utils\Utilsv2;
use App\Lib\Utils\ValidatorBuilder;
use App\Models\Member;
use App\Notifications\SendMailVerifyCodeNotification;
use App\Notifications\VerifyEmailNotification;
use App\View\Components\Alert;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Symfony\Component\HttpFoundation\Response as ResponseHTTP;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $members = Member::paginate(30);
        //debugbar()->info($members);
        return view('members', $this::baseGlobalVariable($request, ['members' => $members, 'user' => $user])->toArrayable());
    }

    public function emailVerify(Request $request)
    {
        //debugbar()->info("emailVerify");
        // 用户验证逻辑
        // 保证 ID 和 Hash 都是正确的
        $user = Member::find($request->route('id'));

        if (!hash_equals((string)$request->route('id'), (string)$user->getKey()) ||
            !hash_equals((string)$request->route('hash'), sha1($user->getEmailForVerification()))) {
            //return response()->json(["msg" => "Invalid verification link"], 400);
            return redirect(route(RouteNameField::PageHome->value))->with('mail_result', 0);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect(route(RouteNameField::PageHome->value))->with('mail_result', 1);
        }

        $user->markEmailAsVerified();

        // 触发邮箱验证成功的事件
        event(new Verified($request->user()));

        // 返回验证成功的响应
        return redirect(route(RouteNameField::PageHome->value))->with('mail_result', 2);
    }

    public function passwordReset(Request $request)
    {
        $cgLCI = self::baseControllerInit($request);
        $i18N = $cgLCI->getI18N();

        $vb = new ValidatorBuilder($i18N, EValidatorType::RESETPASSWORD);
        $v = $vb->validate($request->all());

        if($v instanceof MessageBag){
            // validator errors here
            return redirect(route(RouteNameField::PageHome->value))->with('invaild',true)->withErrors($v);
        }else{
            return view('passwordreset', $this::baseGlobalVariable($request, ['token'=>$v["token"],'email'=>$v["email"]])->toArrayable());
        }
    }

    public function passwordResetPost(Request $request)
    {
        $cgLCI = self::baseControllerInit($request);
        $i18N = $cgLCI->getI18N();

        $vb = new ValidatorBuilder($i18N, EValidatorType::RESETPASSWORD);
        $v = $vb->validate($request->only('email', 'password', 'password_confirmation', 'token'));

        if($v instanceof MessageBag){
            // validator errors here
            return redirect(route(RouteNameField::PagePasswordReset->value))->withInput()->withErrors($v);
        }else{
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (Member $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));
                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            //debugbar()->info($status);
            $ELanguageText = ELanguageText::valueof(str_replace(".", "_", $status));
            return $status === Password::PASSWORD_RESET
                ? redirect()->route('member.form-login')->with('status', $ELanguageText)
                : back()->withErrors(['email' => [$ELanguageText]]);
        }
    }

    public function  forgetPassword(Request $request)
    {
        return view('forgot-password', Controller::baseControllerInit($request)->toArrayable());
    }

    public function forgetPasswordPost(Request $request)
    {
        $cgLCI = self::baseControllerInit($request);
        $i18N = $cgLCI->getI18N();

        $vb = new ValidatorBuilder($i18N, EValidatorType::FORGOTPASSWORD);

        $validator = Validator::make($request->all(), $vb->getRules(), $vb->getCustomMessages(), $vb->getAtters());
        $validate = $validator->validate();

        if ($validator instanceof MessageBag) {
            // validator errors here
            return redirect(route(RouteNameField::PageForgetPassword->value))->withInput()->withErrors($validate);
        }else{
            $cacheKey = $validate['email'].":forgetpassword";
            if (Cache::has($cacheKey)) {
                return redirect(route(RouteNameField::PageHome->value))->with('mail', false);
            }else{
                $status = Password::sendResetLink(
                    ['email'=>$validate['email']]
                );
                Cache::put($cacheKey, true, now()->addSeconds(60));
                $ELanguageText = ELanguageText::valueof(str_replace(".", "_", $status));
                return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => $i18N->getLanguage($ELanguageText)])
                    : back()->withErrors(['email' => $i18N->getLanguage($ELanguageText)]);
            }
        }
    }

    public function resendEmail(Request $request)
    {
        $cgLCI = self::baseControllerInit($request);
        $i18N = $cgLCI->getI18N();

        $user = Auth::user();
        if ($user->hasVerifiedEmail()) {
            return redirect(route(RouteNameField::PageHome->value))->with('mail_result', 1);
        }
        $cacheKey = $user->UUID . ":mail-sent";
        if (Cache::has($cacheKey)) {
            return redirect(route(RouteNameField::PageHome->value))->with('mail', false);
        } else {
            $user->notify(new VerifyEmailNotification($i18N));
            Cache::put($cacheKey, true, now()->addSeconds(60));
            return redirect(route(RouteNameField::PageHome->value))->with('mail', true);
        }
    }

    public function loginPage(Request $request)
    {
        return view('login', $this::baseControllerInit($request)->toArrayable());
    }

    public function logout(Request $request)
    {
        $cgLCI = self::baseControllerInit($request);
        $i18N = $cgLCI->getI18N();
        $fingerprint = $cgLCI->getFingerprint();

        Log::info($request->user()["username"] . ": logout");
        event((new UserNotification([
            $i18N->getLanguage(ELanguageText::logout_context, true)->placeholderParser("s", 5)->toString(),
            $i18N->getLanguage(ELanguageText::logout_title),
            "warning",
            10000,
            Cache::get('guest_id'.$fingerprint)
        ]))->delay(now()->addSeconds(3)));
        Auth::logout();
        return view('logout', $this::baseControllerInit($request)->toArrayable());
    }

    public function showRegistrationForm(Request $request): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('register', $this::baseControllerInit($request)->toArrayable());
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function register(Request $request)
    {
        $cgLCI = self::baseControllerInit($request);
        $i18N = $cgLCI->getI18N();
        $fingerprint = $cgLCI->getFingerprint();

        $vb = new ValidatorBuilder($i18N, EValidatorType::REGISTER);
        $v = $vb->validate($request->all(), [
            'password',
            'password_confirmation'
        ], true);
        if($v instanceof MessageBag){
            Log::info($request->ip() . ": " . PHP_EOL . "    Request(Json)=" . Json::encode($request->all()));
            event(new UserNotification([
                implode('<br>', $v->all()),
                "驗證失敗",
                "error",
                "10000",
                Cache::get("guest_id".$fingerprint)
            ]));
            $alert = new Alert("%type%", $v->all());
            return response()->json([
                "message" => $alert,
                "error_keys" => $v->keys(),
            ], ResponseHTTP::HTTP_BAD_REQUEST);
                //redirect('register')->withErrors($v)->withInput();
        }else{
            if($v['token'] !== (new CSRF(RouteNameField::PageRegisterPost->value))->get()) return response()->json([
                "message" => "CSRF 驗證碼失效",
                "error_keys" => ['token'],
            ], ResponseHTTP::HTTP_BAD_REQUEST);
            // 可以在这里实现登录逻辑，或者重定向到登录页面
            Log::info($v['username'] . ": registering");
            $user = Member::create([
                'username' => $v['username'],
                'email' => $v['email'],
                'phone' => $v['phone'],
                'password' => Hash::make($v['password']),
                'enable' => 'true',
                'administrator' => 'false'
            ]);
            Log::info($user->username . ": registered");

            // 发送验证邮件
            $cacheKey = $user->UUID . ":mail-sent";
            if(Cache::has($cacheKey)) {
                event(new UserNotification([
                    $i18N->getLanguage(ELanguageText::notification_email_description),
                    $i18N->getLanguage(ELanguageText::notification_email_verifyTitle),
                    "warning",
                    "10000",
                    Cache::get("guest_id".$fingerprint)
                ]));
                return response()->json([
                    "message" => "註冊成功請驗證信箱!!在 1 小時候驗證將過期",
                    "redirect" => route(RouteNameField::PageHome->value)
                ]);
            }else{
                Log::info($user->username . ": mailing");
                $instance = new VerifyEmailNotification($i18N);
                $instance->delay(now()->addSeconds(5));
                $user->notify($instance);
                Log::info($user->username . ": mailed");
                Cache::put($cacheKey, true, now()->addHours(1));
                Auth::login($user);
                Member::
                event(new UserNotification([
                    $i18N->getLanguage(ELanguageText::notification_email_description),
                    $i18N->getLanguage(ELanguageText::notification_email_verifyTitle),
                    "success",
                    "10000",
                    Cache::get("guest_id".$fingerprint)
                ]));
                return response()->json([
                    "message" => "註冊成功請驗證信箱!!在 1 小時候驗證將過期",
                    "redirect" => route(RouteNameField::PageHome->value)
                ]);
            }
            //return redirect(route("home"))->with('mail', true);
        }
    }

    public function login(Request $request)
    {
        $cgLCI = self::baseControllerInit($request);
        $i18N = $cgLCI->getI18N();
        $fingerprint = $cgLCI->getFingerprint();

        $vb = new ValidatorBuilder($i18N, EValidatorType::LOGIN);
        try {
            $validator = Validator::make($request->all(), $vb->getRules(), $vb->getCustomMessages(), $vb->getAtters());
            $validate = $validator->validate();
        } catch (ValidationException $e) {
            Log::info($request->ip() . ": " . PHP_EOL . "    ValidationException=" . $e->getMessage() . "," . PHP_EOL . "    Request(Json)=" . Json::encode($request->all()));
        }

        if (isset($validator)) {
            if (!$validator->fails()) {
                if (isset($validate)) {
                    $user = Member::where("username", $validate["username"])->first();
                    if ($user !== null) {
                        if (Hash::check($validate["password"], $user["password"])) {
                            Log::info($user->username . ": Logging in");
                            Auth::login($user);
                            Log::info($user->username . ": logined");
                            if(Auth::check() && Auth::user()->enable==="false"){
                                $errors = new MessageBag;
                                $errors->add('username', "你的帳號因已經停用，所以你已被強制登出。 Notification ID:". Cache::get("guest_id".$fingerprint));
                                event((new UserNotification([
                                    "你的帳號因已經停用，所以你已被強制登出。",
                                    "警告訊息",
                                    "warning",
                                    10000,
                                    Cache::get('guest_id'.$fingerprint)
                                ]))->delay(now()->addSeconds(8)));
                                Auth::logout();
                                return back()->withErrors($errors);
                            }
                            return redirect(route(RouteNameField::PageHome->value))->with('custom_message', [
                                $i18N->getLanguage(ELanguageText::notification_login_title),
                                $i18N->getLanguage(ELanguageText::notification_login_success),
                                ENotificationType::success
                            ]);
                        } else {
                            // 自訂錯誤訊息
                            $validator->errors()->add("login_faild",
                                $i18N->getLanguage(ELanguageText::login_faild, true)
                                    ->Replace("%validator_field_username%", $i18N->getLanguage(ELanguageText::validator_field_username))
                                    ->Replace("%validator_field_password%", $i18N->getLanguage(ELanguageText::validator_field_password))
                                    ->toString()
                            );
                            Log::info($request->ip() . ": " . PHP_EOL . "    ValidationException=asd," . PHP_EOL . "    Request(Json)=" . Json::encode($request->all()));
                        }
                    } else {
                        $validator->errors()->add("login_username_notfound",
                            $i18N->getLanguage(ELanguageText::login_username_notfound, true)
                                ->Replace("%validator_field_username%", $i18N->getLanguage(ELanguageText::validator_field_username))
                                ->toString()
                        );
                    }
                }
            }
        }
        return redirect(route('member.form-login'))->with('custom_message', [
            $i18N->getLanguage(ELanguageText::notification_login_title),
            $i18N->getLanguage(ELanguageText::notification_login_failed),
            ENotificationType::error
        ])->withInput()->withErrors($validator->errors());
    }

    public function profile(Request $request)
    {
        return view('profile', $this::baseControllerInit($request)->toArrayable());
    }

    public function profilePost(Request $request)
    {
        $cgLCI = self::baseControllerInit($request);
        $i18N = $cgLCI->getI18N();

        $vb = new ValidatorBuilder($i18N, EValidatorType::PROFILEGENERAL);
        $v = $vb->validate($request->all(), [
            'sendMailVerifyCodeToken'
        ], true);
        if($v instanceof MessageBag){
            // validator errors here
            return response()->json(["messages"=>"驗證失敗 1",'errors'=>$v->all()]);
        } else {
            if (!(new CSRF('profile.profilepost'))->equal($v['token'])) {
                return response()->json([
                    "message"=> "CSRF 驗證失敗",
                    "value" => [
                        (new CSRF('profile.profilepost'))->get(),
                        $v['token'],
                    ]
                ], ResponseHTTP::HTTP_BAD_REQUEST);
            }
            if(!isset($v['method'])) return response()->json(["messages"=>"缺少 method"], ResponseHTTP::HTTP_BAD_REQUEST);
            switch ($v['method']){
                case 'email':
                    $vb1 = new ValidatorBuilder($i18N, EValidatorType::PROFILEUPDATEEMAIL);
                    $v1 = $vb1->validate($request->all());
                    if($v1 instanceof MessageBag){
                        // validator errors here
                        return response()->json(["messages"=>"驗證失敗 2",'errors'=>$v1->all()]);
                    }else{
                        if(!Session::has('profile.email.newMailVerifyCode')) return response()->json(["message"=>"沒有 Session 資料"], ResponseHTTP::HTTP_BAD_REQUEST);
                        if(Session::get('profile.email.newMailVerifyCode') !== $v1['verification']) return response()->json(["message"=>"Session 資料不相同"], ResponseHTTP::HTTP_BAD_REQUEST);
                        if (Session::get("profile.email.sendMailVerifyCodeToken") !== $v['sendMailVerifyCodeToken']) {
                            return response()->json(["message"=>"錯誤 信箱身份驗證權杖"], ResponseHTTP::HTTP_BAD_REQUEST);
                        }
                        return $this->profilepost_email($request, $v1, $i18N);
                    }
                case 'password':
                    $vb1 = new ValidatorBuilder($i18N, EValidatorType::PROFILEUPDATEPASSWORD);
                    //Log::info("password: ". \Psy\Util\Json::encode($request->all()));
                    $v1 = $vb1->validate($request->all(), [
                        "current-ps","password","password_confirmation"
                    ],true);
                    if($v1 instanceof MessageBag){
                        // validator errors here
                        //Log::info("MessageBag: ". serialize($v1));
                        return response()->json(["messages"=>"驗證失敗 2",'errors'=>$v1->all()], ResponseHTTP::HTTP_BAD_REQUEST);
                    }else{
                        //Log::info("password: ". \Psy\Util\Json::encode($v1));
                        if (Session::get("profile.password.sendMailVerifyCodeToken") !== $v['sendMailVerifyCodeToken']) {
                            return response()->json(["message"=>"錯誤 信箱身份驗證權杖"], ResponseHTTP::HTTP_BAD_REQUEST);
                        }
                        $member = Auth::user();
                        //Log::info("password Verify: ".PHP_EOL.$v1['current-ps'].PHP_EOL.$member->getAuthPassword());
                        //Log::info("password Verify: ".Hash::check($v1['current-ps'], $member->getAuthPassword()));
                        //Log::info("test Verify: ".Hash::check("5as19fg1a9sg", $member->getAuthPassword()));
                        if (!Hash::check($v1['current-ps'], $member->getAuthPassword())) {
                            return response()->json(["message"=>"錯誤 密碼"], ResponseHTTP::HTTP_BAD_REQUEST);
                        }
                        return $this->profilepost_password($request, $v1, $i18N);
                    }
                    break;
            }
        }
    }

    private function profilepost_password(Request $request, array $v, I18N $i18N)
    {
        $member = Auth::user();
        if($member instanceof Member){
            $member->forceFill([
                'password' => Hash::make($v['password'])
            ]);
            $member->save();
        }
        (new CSRF('profile.password.sendMailVerifyCode'))->release();
        Session::forget('profile.password.MailVerifyCode');
        return response()->json(["message"=>"Password 資料更新成功"]);
    }

    /**
     * @param Request $request
     * @param array $v
     * @param I18N $i18N
     * @return JsonResponse
     */
    private function profilepost_email(Request $request, array $v, I18N $i18N): JsonResponse
    {
        $member = Auth::user();
        if($member instanceof Member){
            $member->fill([
                'email' => $v['email']
            ]);
            $member->save();
        }
        (new CSRF('profile.email.sendMailVerifyCode'))->release();
        Session::forget('profile.email.newMailVerifyCode');
        return response()->json(["message"=>"Email 資料更新成功"]);
    }

    /**
     * @throws Exception
     */
    public function sendMailVerifyCode_profile_email(Request $request)
    {
        $cgLCI = self::baseControllerInit($request);
        $i18N = $cgLCI->getI18N();

        $vb = new ValidatorBuilder($i18N, EValidatorType::SENDMAILVERIFYCODE);
        $v = $vb->validate($request->all());
        if($v instanceof MessageBag){
            // validator errors here
            return response()->json(["messages"=>"驗證失敗",'errors'=>$v->all()], ResponseHTTP::HTTP_BAD_REQUEST);
        }else{
            if (!(new CSRF('profile.email.sendMailVerifyCode'))->equal($request['token'])) {
                return response()->json([
                    "message"=> "CSRF 驗證失敗",
                ], ResponseHTTP::HTTP_BAD_REQUEST);
            }
            $member = Auth::user();
            $cacheKey = $member->UUID . ":sendMailVerifyCode";

            $csrf = (new CSRF('profile.email.sendMailVerifyCode'))->reset()->get();
            if(Cache::has($cacheKey)){
                return response()->json([
                    "message"=>$i18N->getLanguage(
                            ELanguageText::sendMailVerifyCode_Response_error1)  ." ".
                        $i18N->getLanguage(ELanguageText::ExpireTime, true)
                            ->placeholderParser("timestamp", Utils::timeStamp(Cache::get($cacheKey)))->toString(),
                    "cooldown" => Cache::get($cacheKey),
                    "token" => $csrf,
                ], ResponseHTTP::HTTP_BAD_REQUEST);
            }else{
                $random = Str::random(5);
                Session::put('profile.email.sendMailVerifyCode', $random);
                //dump($i18N);
                $notification = new SendMailVerifyCodeNotification($i18N, $random);
                Notification::send($member, $notification->delay(now()->addSeconds(5)));
                Cache::put($cacheKey, time()+60, 60);
                return response()->json([
                    "message"=>$i18N->getLanguage(
                            ELanguageText::sendMailVerifyCode_Response_success)  ." ".
                        $i18N->getLanguage(ELanguageText::ExpireTime, true)
                            ->placeholderParser("timestamp", Utils::timeStamp(Cache::get($cacheKey)))->toString(),
                    "cooldown" => Cache::get($cacheKey),
                    "token" => $csrf,
                ], ResponseHTTP::HTTP_OK);
            }
        }
        //return response()->json([
        //    "message" => $i18N->getLanguage(ELanguageText::HTTP_FORBIDDEN),
        //],ResponseHTTP::HTTP_FORBIDDEN);
    }

    public function newMailVerifyCode_profile_email(Request $request)
    {
        $cgLCI = self::baseControllerInit($request);
        $i18N = $cgLCI->getI18N();

        $vb = new ValidatorBuilder($i18N, EValidatorType::NEWMAILVERIFYCODE);
        $v = $vb->validate($request->all());

        if($v instanceof MessageBag){
            // validator errors here
            return response()->json(["messages"=>"驗證失敗",'errors'=>$v->all()]);
        }else {
            if (!(new CSRF('profile.email.newMailVerifyCode'))->equal($request['token'])) {
                return response()->json([
                    "message" => "CSRF 驗證失敗",
                ], ResponseHTTP::HTTP_BAD_REQUEST);
            }
            $member = Auth::user();
            if($member instanceof Member) {
                $csrf = (new CSRF('profile.email.newMailVerifyCode'))->reset()->get();
                $cacheKey = $member->UUID . ":newMailVerifyCode";
                if($v['email'] === $member->email){
                    return response()->json([
                        "message"=> "無法更換相同的電子信箱",
                        "token" => $csrf,
                    ], ResponseHTTP::HTTP_BAD_REQUEST);
                }
                if(Cache::has($cacheKey)){
                    return response()->json([
                        "message"=>$i18N->getLanguage(
                            ELanguageText::sendMailVerifyCode_Response_error1)  ." ".
                        $i18N->getLanguage(ELanguageText::ExpireTime, true)
                            ->placeholderParser("timestamp", Utils::timeStamp(Cache::get($cacheKey)))->toString(),
                        "token" => $csrf,
                    ], ResponseHTTP::HTTP_BAD_REQUEST);
                }else{
                    $random = Str::random(5);
                    Session::put('profile.email.newMailVerifyCode', $random);

                    $notification = new SendMailVerifyCodeNotification($i18N, $random);
                    $notification->delay(Carbon::now()->addSeconds(5));
                    Notification::route('mail', $v['email'])->notify($notification);
                    Cache::put($cacheKey, time()+60, 60);
                    return response()->json([
                        "message"=>$i18N->getLanguage(
                                ELanguageText::sendMailVerifyCode_Response_success) ." ".
                            $i18N->getLanguage(ELanguageText::ExpireTime, true)
                                ->placeholderParser("timestamp", Utils::timeStamp(Cache::get($cacheKey)))->toString(),
                        "token" => $csrf,
                    ], ResponseHTTP::HTTP_OK);
                }
            }
        }
    }

    public function verifyCode_profile_email(Request $request)
    {
        $cgLCI = self::baseControllerInit($request);
        $i18N = $cgLCI->getI18N();

        $vb = new ValidatorBuilder($i18N, EValidatorType::VERIFYCODE);
        $v = $vb->validate($request->all());

        if($v instanceof MessageBag){
            // validator errors here
            return response()->json(["messages"=>"驗證失敗",'errors'=>$v->all()], ResponseHTTP::HTTP_BAD_REQUEST);
        }else{
            if (!(new CSRF('profile.email.verifyCode'))->equal($request['token'])) {
                return response()->json([
                    "message"=> "CSRF 驗證失敗",
                ], ResponseHTTP::HTTP_BAD_REQUEST);
            }
            $code = Session::get('profile.email.sendMailVerifyCode');
            if($code === $v['code']){
                Session::forget('profile.email.sendMailVerifyCode');
                $str = Str::random(10);
                Session::put("profile.email.sendMailVerifyCodeToken", $str);
                return response()->json(["messages"=>"驗證成功", "access_token" => Utilsv2::encodeContext($str)['compress']]);
            }else{
                return response()->json(["messages"=>"驗證碼錯誤"], ResponseHTTP::HTTP_BAD_REQUEST);
            }
        }
    }

    public function sendMailVerifyCode_profile_password(Request $request)
    {
        $cgLCI = self::baseControllerInit($request);
        $i18N = $cgLCI->getI18N();

        $vb = new ValidatorBuilder($i18N, EValidatorType::SENDMAILVERIFYCODE);
        $v = $vb->validate($request->all());
        if($v instanceof MessageBag){
            // validator errors here
            return response()->json(["message"=>"驗證失敗",'errors'=>$v->all()], ResponseHTTP::HTTP_BAD_REQUEST);
        }else{
            if (!(new CSRF('profile.password.sendMailVerifyCode'))->equal($request['token'])) {
                return response()->json([
                    "message"=> "CSRF 驗證失敗",
                ], ResponseHTTP::HTTP_BAD_REQUEST);
            }
            $member = Auth::user();
            $cacheKey = $member->UUID . ":profile.password.sendMailVerifyCode";

            $csrf = (new CSRF('profile.password.sendMailVerifyCode'))->reset()->get();
            if(Cache::has($cacheKey)){
                return response()->json([
                    "message"=>$i18N->getLanguage(
                            ELanguageText::sendMailVerifyCode_Response_error1)  ." ".
                        $i18N->getLanguage(ELanguageText::ExpireTime, true)
                            ->placeholderParser("timestamp", Utils::timeStamp(Cache::get($cacheKey)))->toString(),
                    "cooldown" => Cache::get($cacheKey),
                    "token" => $csrf,
                ], ResponseHTTP::HTTP_BAD_REQUEST);
            }else{
                $random = Str::random(5);
                Session::put('profile.password.sendMailVerifyCode', $random);
                //dump($i18N);
                $notification = new SendMailVerifyCodeNotification($i18N, $random);
                Notification::send($member, $notification->delay(now()->addSeconds(5)));
                Cache::put($cacheKey, time()+60, 60);
                return response()->json([
                    "message"=>$i18N->getLanguage(
                            ELanguageText::sendMailVerifyCode_Response_success)  ." ".
                        $i18N->getLanguage(ELanguageText::ExpireTime, true)
                            ->placeholderParser("timestamp", Utils::timeStamp(Cache::get($cacheKey)))->toString(),
                    "cooldown" => Cache::get($cacheKey),
                    "token" => $csrf,
                ], ResponseHTTP::HTTP_OK);
            }
        }
    }

    public function verifyCode_profile_password(Request $request)
    {
        $cgLCI = self::baseControllerInit($request);
        $i18N = $cgLCI->getI18N();

        $vb = new ValidatorBuilder($i18N, EValidatorType::VERIFYCODE);
        $v = $vb->validate($request->all());

        if($v instanceof MessageBag){
            // validator errors here
            return response()->json(["messages"=>"驗證失敗",'errors'=>$v->all()], ResponseHTTP::HTTP_BAD_REQUEST);
        }else{
            if (!(new CSRF('profile.password.verifyCode'))->equal($request['token'])) {
                return response()->json([
                    "message"=> "CSRF 驗證失敗",
                ], ResponseHTTP::HTTP_BAD_REQUEST);
            }
            $code = Session::get('profile.password.sendMailVerifyCode'); // 原始驗證碼
            if($code === $v['code']){
                Session::forget('profile.password.sendMailVerifyCode');
                $str = Str::random(10);
                Session::put("profile.password.sendMailVerifyCodeToken", $str); // 許可驗證碼
                return response()->json(["messages"=>"驗證成功", "access_token" => Utilsv2::encodeContext($str)['compress']]);
            }else{
                return response()->json(["messages"=>"驗證碼錯誤"], ResponseHTTP::HTTP_BAD_REQUEST);
            }
        }
    }
}

