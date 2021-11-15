<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Restaurant\LunchController;
use App\Http\Controllers\Restaurant\MenuController;
use App\Http\Controllers\Cafe\CafeController;
use App\Http\Controllers\ServiceHours\ServiceHourController;
use App\Http\Controllers\Mail\ContactController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware("auth:sanctum")->get("/user", function (Request $request) {
    return $request->user();
});

Route::get("/restaurant/lunch", [LunchController::class, "get"]);
Route::get("/restaurant/menu", [MenuController::class, "get"]);
//Route::get("/restaurant/data", [MenuController::class, "get"]);


Route::get("/cafe/menu", [CafeController::class, "get"]);
//Route::get("/cafe/data", [CafeController::class, "get"]);

Route::get("/servicehours", [ServiceHourController::class, "get"]);
Route::get("/servicehours/closeduntil", [serviceHourController::class, "get_closed_until"]);

Route::post("/mail/contact", [ContactController::class, "submit"]);
//middleware(["middleware" => "trusted_access"])->
