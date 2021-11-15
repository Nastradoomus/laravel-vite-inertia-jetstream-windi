<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Restaurant\LunchController;
use App\Http\Controllers\Restaurant\MenuController;
use App\Http\Controllers\Defaults\RestaurantController as DefaultsController;
use Inertia\Inertia;

// LUNCH
Route::get("/lunch/authorized", [LunchController::class, "get"]);
Route::get("/lunch", function () {
    return Inertia::render("Restaurant/Lunch");
})->name("restaurant.lunch");

Route::get("/defaults/authorized/lunch", [DefaultsController::class, "get_lunches_defaults"]);

Route::post("/lunch/authorized/post", [LunchController::class, "post_lunch"]);
Route::post("/lunch/authorized/date", [LunchController::class, "post_date"]);
Route::post("/lunch/authorized/date/defaults", [LunchController::class, "post_defaults"]);
Route::post("/lunch/authorized/delete", [LunchController::class, "delete_lunch"]);


// MENU
Route::get("/menu", [MenuController::class, "get"])->name("restaurant.menu");

Route::post("/menu/authorized/type", [MenuController::class, "post_type"]);
Route::post("/menu/authorized/item", [MenuController::class, "post_item"]);
Route::post("/menu/authorized/item/delete", [MenuController::class, "delete_item"]);

Route::delete("/menu/authorized/type", [MenuController::class, "delete_type"]);
