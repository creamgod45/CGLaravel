<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MemberController;
use App\Http\Middleware\EMiddleWareAliases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/setlanguage', function (Request $request){
    $cookie = Cookie::make("lang", $request["lang"], 60);
    return response()->json(['message' => 'Data received successfully'])->cookie($cookie);
});

Route::middleware(EMiddleWareAliases::auth->name)->group(function () {
    //Route::get('logout', [MemberController::class, 'logout'])->name('logout');
    Route::get('members', [MemberController::class, 'index'])->name("index");
});

Route::middleware(EMiddleWareAliases::guest->name)->group(function () {
    Route::get('login', [MemberController::class, 'loginPage']);
    Route::post('login', [MemberController::class, 'login'])->name('login');
    Route::get('register', [MemberController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [MemberController::class, 'register']);
});
