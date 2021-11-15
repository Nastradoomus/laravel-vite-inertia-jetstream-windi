<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Defaults\RestaurantController;


// DATA
Route::get("/", [RestaurantController::class, "get"])->name("restaurant.data");

// POST DATA
Route::post("/authorized", [RestaurantController::class, "post"]);
