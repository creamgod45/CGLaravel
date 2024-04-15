<?php

namespace App\Http\Controllers;

use App\Lib\I18N\ELanguageCode;
use App\Lib\I18N\I18N;
use App\Lib\Utils\Utils;
use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $members = Member::all();
        return view('members', $this->baseGlobalVariable($request, ['members' => $members]));
    }

    public function loginPage(Request $request){
        return view('login', $this->baseGlobalVariable($request));
    }

    public function login(Request $request){
        $data = $request->all();
        $user = Member::where("username", $data["username"])->first();
        if(Hash::check($data["password"], $user["password"])){
            Auth::login($user);
            return redirect(route("index"));
        }
        return '登入失敗';
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect(route('login'));
    }

    public function showRegistrationForm(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('register', $this->baseGlobalVariable($request));
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
            Auth::login($user);
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

