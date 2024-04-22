<?php

namespace App\Http\Controllers;

use App\Lib\I18N\ELanguageText;
use App\Lib\I18N\I18N;
use App\Lib\Permission\cases\AdministratorPermission;
use App\Lib\Utils\EValidatorType;
use App\Lib\Utils\ValidatorBuilder;
use App\Models\Member;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use function Laravel\Prompts\error;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $members = Member::paginate(10);
        //debugbar()->info($members);
        return view('members', $this::baseGlobalVariable($request, ['members' => $members, 'user' => $user]));
    }

    public function loginPage(Request $request){
        return view('login', $this::baseControllerInit($request));
    }

    public function login(Request $request){
        $baseControllerInit = self::baseControllerInit($request);
        $i18N = $baseControllerInit['i18N'];
        if(!$i18N instanceof I18N) throw new Exception('$i18N Not instanceof I18N');
        $data = $request->all();
        $validatorBuilder = new ValidatorBuilder($i18N, EValidatorType::LOGIN);

        try {
            $validator = Validator::make($data, $validatorBuilder->getRules(), $validatorBuilder->getCustomMessages(), $validatorBuilder->getAtters());
            $validate = $validator->validate();
        } catch (ValidationException $e) {
            Log::info($request->ip().": ".PHP_EOL."    ValidationException=".$e->getMessage().",".PHP_EOL."    Request(Json)=".Json::encode($request->all()));
        }
        if (isset($validator)) {
            if(!$validator->fails()){
                if (isset($validate)) {
                    $user = Member::where("username", $validate["username"])->first();
                    if ($user !== null) {
                        if(Hash::check($validate["password"], $user["password"])){
                            Log::info($user->username.": Logging in");
                            Auth::login($user);
                            Log::info($user->username.": logined");
                            return redirect('members');
                        }else{
                            // 自訂錯誤訊息
                            $validator->errors()->add("login_faild",
                                $i18N->getLanguage(ELanguageText::login_faild, true)
                                    ->Replace("%validator_field_username%", $i18N->getLanguage(ELanguageText::validator_field_username))
                                    ->Replace("%validator_field_password%", $i18N->getLanguage(ELanguageText::validator_field_password))
                                    ->toString()
                            );
                            Log::info($request->ip().": ".PHP_EOL."    ValidationException=asd,".PHP_EOL."    Request(Json)=".Json::encode($request->all()));
                        }
                    }else{
                        $validator->errors()->add("login_username_notfound",
                            $i18N->getLanguage(ELanguageText::login_username_notfound, true)
                                ->Replace("%validator_field_username%", $i18N->getLanguage(ELanguageText::validator_field_username))
                                ->toString()
                        );
                    }
                }
            }
        }
        return redirect(route('login'))->withInput()->withErrors($validator->errors());
    }

    public function logout(Request $request)
    {
        Log::info($request->user()["username"].": logout");
        Auth::logout();
        return view('logout', $this::baseControllerInit($request));
    }

    public function showRegistrationForm(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
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
        if(!$i18N instanceof I18N) throw new Exception('$i18N Not instanceof I18N');
        $rules = [
            'username' => [ 'required', 'string', 'max:255', 'unique:members'],
            'email'    => [ 'required', 'string', 'email', 'max:255', 'unique:members'],
            'password' => [ 'required', 'string', 'min:8', 'confirmed'],
            'phone'    => [ 'required', 'string', 'min:10', 'max:255', 'unique:members'],
        ];
        $customMessages = [
            'required' => $i18N->getLanguage(ELanguageText::validator_required),
            'string' => $i18N->getLanguage(ELanguageText::validator_string),
            'min' => $i18N->getLanguage(ELanguageText::validator_min),
            'max' => $i18N->getLanguage(ELanguageText::validator_max),
            'confirmed' => $i18N->getLanguage(ELanguageText::validator_confirmed, true)
                ->Replace("%validator_field_passwordConfirmed%", $i18N->getLanguage(ELanguageText::validator_field_passwordConfirmed))
                ->toString(),
            'unique' => $i18N->getLanguage(ELanguageText::validator_unique),
        ];
        $atters=[
            'username' => $i18N->getLanguage(ELanguageText::validator_field_username),
            'email'    => $i18N->getLanguage(ELanguageText::validator_field_email),
            'password' => $i18N->getLanguage(ELanguageText::validator_field_password),
            'phone'    => $i18N->getLanguage(ELanguageText::validator_field_phone),
        ];

        try {
            $validator = Validator::make($request->all(), $rules, $customMessages, $atters);
            $validate = $validator->validate();
        } catch (ValidationException $e) {
            Log::info($request->ip().": ".PHP_EOL."    ValidationException=".$e->getMessage().",".PHP_EOL."    Request(Json)=".Json::encode($request->all()));
        }

        if (!empty($validate)) {
            $user = Member::create([
                'username' => $validate['username'],
                'email' => $validate['email'],
                'phone' => $validate['phone'],
                'password' => Hash::make($validate['password']),
                'enable' => 'true',
                'administrator' => 'false'
            ]);

            // 可以在这里实现登录逻辑，或者重定向到登录页面
            Log::info($user->username.": registering");

            event(new Registered($user));

            Log::info($user->username.": registered");
            return redirect(route("home"));
        }
        return redirect('register')->withErrors($validator->errors())->withInput();
    }
}

