<?php /** @noinspection DuplicatedCode */

namespace App\Http\Controllers;

use App\Lib\I18N\ELanguageText;
use App\Lib\I18N\I18N;
use App\Lib\Utils\ENotificationType;
use App\Lib\Utils\EValidatorType;
use App\Lib\Utils\ValidatorBuilder;
use App\Models\Member;
use App\Notifications\VerifyEmailNotification;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Nette\Utils\Json;
use Nette\Utils\JsonException;

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
        return view('members', $this::baseGlobalVariable($request, ['members' => $members, 'user' => $user]));
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
            return redirect(route("home"))->with('mail_result', 0);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect(route("home"))->with('mail_result', 1);
        }

        $user->markEmailAsVerified();

        // 触发邮箱验证成功的事件
        event(new Verified($request->user()));

        // 返回验证成功的响应
        return redirect(route("home"))->with('mail_result', 2);
    }

    public function passwordreset(Request $request)
    {
        $baseControllerInit = self::baseControllerInit($request);
        $i18N = $baseControllerInit['i18N'];
        if (!$i18N instanceof I18N) throw new Exception('$i18N Not instanceof I18N');
        $vb = new ValidatorBuilder($i18N, EValidatorType::RESETPASSWORD);
        $v = $vb->validate($request->all());

        if($v instanceof MessageBag){
            // validator errors here
            return redirect(route('home'))->with('invaild',true)->withErrors($v);
        }else{
            return view('passwordreset', $this::baseGlobalVariable($request, ['token'=>$v["token"],'email'=>$v["email"]]));
        }
    }

    public function passwordresetpost(Request $request)
    {
        $baseControllerInit = self::baseControllerInit($request);
        $i18N = $baseControllerInit['i18N'];
        if (!$i18N instanceof I18N) throw new Exception('$i18N Not instanceof I18N');
        $vb = new ValidatorBuilder($i18N, EValidatorType::RESETPASSWORD);
        $v = $vb->validate($request->only('email', 'password', 'password_confirmation', 'token'));

        if($v instanceof MessageBag){
            // validator errors here
            return redirect(route('password.reset'))->withInput()->withErrors($v);
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

            debugbar()->info($status);
            $ELanguageText = ELanguageText::valueof(str_replace(".", "_", $status));
            return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', $ELanguageText)
                : back()->withErrors(['email' => [$ELanguageText]]);
        }
    }

    public function forgetpassword(Request $request)
    {
        return view('forgot-password', Controller::baseControllerInit($request));
    }

    public function forgetpasswordpost(Request $request)
    {
        $baseControllerInit = self::baseControllerInit($request);
        $i18N = $baseControllerInit['i18N'];
        if (!$i18N instanceof I18N) throw new Exception('$i18N Not instanceof I18N');

        $vb = new ValidatorBuilder($i18N, EValidatorType::FORGOTPASSWORD);

        $validator = Validator::make($request->all(), $vb->getRules(), $vb->getCustomMessages(), $vb->getAtters());
        $validate = $validator->validate();

        if ($validator instanceof MessageBag) {
            // validator errors here
            return redirect(route('password.request'))->withInput()->withErrors($validate);
        }else{
            $cacheKey = $validate['email'].":forgetpassword";
            if (Cache::has($cacheKey)) {
                return redirect(route("home"))->with('mail', false);
            }else{
                $status = Password::sendResetLink(
                    $request->only('email')
                );
                $ELanguageText = ELanguageText::valueof(str_replace(".", "_", $status));
                return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => $i18N->getLanguage($ELanguageText)])
                    : back()->withErrors(['email' => $i18N->getLanguage($ELanguageText)]);
            }
        }
    }

    public function resendEmail(Request $request)
    {
        $baseControllerInit = self::baseControllerInit($request);
        $i18N = $baseControllerInit['i18N'];
        if (!$i18N instanceof I18N) throw new Exception('$i18N Not instanceof I18N');

        $user = Auth::user();
        if ($user->hasVerifiedEmail()) {
            return redirect(route("home"))->with('mail_result', 1);
        }
        $cacheKey = $user->UUID . ":mail-sent";
        if (Cache::has($cacheKey)) {
            return redirect(route("home"))->with('mail', false);
        } else {
            $user->notify(new VerifyEmailNotification($i18N));
            return redirect(route("home"))->with('mail', true);
        }
    }

    public function loginPage(Request $request)
    {
        return view('login', $this::baseControllerInit($request));
    }

    public function logout(Request $request)
    {
        Log::info($request->user()["username"] . ": logout");
        Auth::logout();
        return view('logout', $this::baseControllerInit($request));
    }

    public function showRegistrationForm(Request $request): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('register', $this::baseControllerInit($request));
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function register(Request $request)
    {
        $baseControllerInit = self::baseControllerInit($request);
        $i18N = $baseControllerInit['i18N'];
        if (!$i18N instanceof I18N) throw new Exception('$i18N Not instanceof I18N');

        $vb = new ValidatorBuilder($i18N, EValidatorType::REGISTER);

        try {
            $validator = Validator::make($request->all(), $vb->getRules(), $vb->getCustomMessages(), $vb->getAtters());
            $validate = $validator->validate();
        } catch (ValidationException $e) {
            Log::info($request->ip() . ": " . PHP_EOL . "    ValidationException=" . $e->getMessage() . "," . PHP_EOL . "    Request(Json)=" . Json::encode($request->all()));
        }

        if (!empty($validate)) {

            // 可以在这里实现登录逻辑，或者重定向到登录页面
            Log::info($validate['username'] . ": registering");
            $user = Member::create([
                'username' => $validate['username'],
                'email' => $validate['email'],
                'phone' => $validate['phone'],
                'password' => Hash::make($validate['password']),
                'enable' => 'true',
                'administrator' => 'false'
            ]);
            Log::info($user->username . ": registered");

            // 发送验证邮件
            Log::info($user->username . ": mailing");
            $user->notify(new VerifyEmailNotification($i18N));
            Log::info($user->username . ": mailed");
            $cacheKey = $user->UUID . ":mail-sent";

            Cache::put($cacheKey, true, 60);
            Auth::login($user);
            return redirect(route("home"))->with('mail', true);
        }
        return redirect('register')->withErrors($validator->errors())->withInput();
    }

    public function login(Request $request)
    {
        $baseControllerInit = self::baseControllerInit($request);
        $i18N = $baseControllerInit['i18N'];
        if (!$i18N instanceof I18N) throw new Exception('$i18N Not instanceof I18N');

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
                            return redirect(route('home'))->with('custom_message', [
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
        return redirect(route('login'))->with('custom_message', [
            $i18N->getLanguage(ELanguageText::notification_login_title),
            $i18N->getLanguage(ELanguageText::notification_login_failed),
            ENotificationType::error
        ])->withInput()->withErrors($validator->errors());
    }
}

