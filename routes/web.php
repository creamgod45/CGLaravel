<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\MemberController;
use App\Http\Middleware\EMiddleWareAliases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    return view('welcome', Controller::baseControllerInit($request));
})->name('home');

Route::post('lzstring.json', function (Request $request){
    return response()->json(['message' => 'Data received successfully', 'raw'=>$request["a"]]);
});

Route::post('language', function (Request $request){
    $cookie = Cookie::make("lang", $request["lang"], 60);
    return response()->json(['message' => 'Data received successfully'])->cookie($cookie);
});

Route::middleware(EMiddleWareAliases::auth->name)->group(function () {
    Route::get('logout', [MemberController::class, 'logout'])->name('logout');
    Route::get('members', [MemberController::class, 'index']);
});

Route::middleware(EMiddleWareAliases::guest->name)->group(function () {
    Route::get('login', [MemberController::class, 'loginPage'])->name('login');
    Route::post('login', [MemberController::class, 'login']);
    Route::get('register', [MemberController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [MemberController::class, 'register']);
});
