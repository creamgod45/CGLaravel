<?php

namespace App\Http\Controllers;

use App\Lib\I18N\ELanguageText;
use App\Lib\I18N\I18N;
use App\Models\Member;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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
        $members = Member::all();
        return view('members', $this::baseGlobalVariable($request, ['members' => $members, 'user' => $user]));
    }

    public function loginPage(Request $request){
        return view('login', $this::baseControllerInit($request));
    }

    public function login(Request $request){
        $data = $request->all();
        $user = Member::where("username", $data["username"])->first();
        if(Hash::check($data["password"], $user["password"])){
            Log::info($user->username.": Logging in");
            Auth::login($user);
            Log::info($user->username.": logined");
            return redirect('members');
        }
        return redirect(route('login'));
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
            $user = $this->create($validate);

            // 可以在这里实现登录逻辑，或者重定向到登录页面
            Log::info($user->username.": registering");
            Auth::login($user);
            Log::info($user->username.": registered");
            return redirect(route("home"));
        }
        return redirect('register')->withErrors($validator->errors())->withInput();
    }

    protected function create(array $data)
    {
        return Member::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'enable' => 'true',
            'administrator' => 'false'
        ]);
    }
}

