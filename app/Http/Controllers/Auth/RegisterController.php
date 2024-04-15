<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Lib\I18N\ELanguageCode;
use App\Lib\I18N\I18N;
use App\Lib\Utils\Utils;
use App\Models\Member;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('register', $this->baseGlobalVariable($request));
    }

    public function register(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validate = $request->validate([
                'username' => [ 'required', 'string', 'max:255', 'unique:members'],
                'email' => [ 'required', 'string', 'email', 'max:255', 'unique:members'],
                'password' => [ 'required', 'string', 'min:8', 'confirmed'],
                'phone' => [ 'required', 'string', 'max:255', 'unique:members'],
            ]);
            debugbar()->debug($validate);
        }catch (Exception $exception){
            debugbar()->error($exception);
        }

        if (!empty($validate)) {
            $user = $this->create($validate);

            // 可以在这里实现登录逻辑，或者重定向到登录页面
            auth()->login($user);
        }
        return redirect('register');
    }


    protected function validator(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'username' => [ 'required', 'string', 'max:255', 'unique:members'],
            'email' => [ 'required', 'string', 'email', 'max:255', 'unique:members'],
            'password' => [ 'required', 'string', 'min:8', 'confirmed'],
            'phone' => [ 'required', 'string', 'max:255', 'unique:members'],
        ]);
    }

    protected function create(array $data)
    {
        debugbar()->error($data);
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
