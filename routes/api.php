<?php

use App\Http\Controllers\AnimalController;
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

Route::apiResource('animal', AnimalController::class);

