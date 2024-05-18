<?php

use App\Http\Controllers\AnimalController;
use App\Http\Middleware\EMiddleWareAliases;
use App\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Cookie;
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

Route::get('down', function (Request $request){
    if (Hash::check($request['key'], '$2y$12$odnzjr7ZJSFqOdkAQrDMzuPY6sHoN6n8aoTozqHYsgojw2A5oyAT6')) {
        if (App::isDownForMaintenance()) {
            App::maintenanceMode()->deactivate();
            return response()->json([
                "message" => "turn off maintenance Mode"
            ]);
        }else{
            $random = Str::random("60");
            App::maintenanceMode()->activate([
                'except' => App::make(PreventRequestsDuringMaintenance::class)->getExcludedPaths(),
                'redirect' => "/",
                'retry' => 60,
                'refresh' => 15,
                'secret' => $random,
                'status' => 503,
                'template' => null,
            ]);
            return response()->json([
                "message" => "turn on maintenance Mode",
                "token" => $random
            ]);
        }
    }
});
