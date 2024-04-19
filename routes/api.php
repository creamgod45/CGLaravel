<?php

use App\Http\Middleware\EMiddleWareAliases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(EMiddleWareAliases::auth->name)->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('lzstring.json', function (Request $request){
    return response()->json(['message' => 'Data received successfully', 'raw'=>$request["a"]]);
});

Route::post('language', function (Request $request){
    $cookie = Cookie::make("lang", $request["lang"], 60);
    return response()->json(['message' => 'Data received successfully'])->cookie($cookie);
});
