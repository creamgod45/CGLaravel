<?php

namespace App\Http\Controllers;

use App\Lib\I18N\ELanguageCode;
use App\Lib\I18N\I18N;
use App\Lib\Permission\cases\AdministratorPermission;
use App\Lib\Utils\Utils;
use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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

    public function register(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validate = $request->validate([
            'username' => [ 'required', 'string', 'max:255', 'unique:members'],
            'email' => [ 'required', 'string', 'email', 'max:255', 'unique:members'],
            'password' => [ 'required', 'string', 'min:8', 'confirmed'],
            'phone' => [ 'required', 'string', 'max:255', 'unique:members'],
        ]);

        if (!empty($validate)) {
            $user = $this->create($validate);

            // 可以在这里实现登录逻辑，或者重定向到登录页面
            Log::info($user->username.": registering");
            Auth::login($user);
            Log::info($user->username.": registered");
            return redirect(route("home"));
        }
        return redirect('register');
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

