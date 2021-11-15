<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cafe\CafeController;

// POST
Route::post("/authorized/type", [CafeController::class, "post_type"]);
Route::post("/authorized/item", [CafeController::class, "post_item"]);
Route::post("/authorized/item/delete", [CafeController::class, "delete_item"]);

Route::delete("/authorized/type", [CafeController::class, "delete_type"]);

Route::get("/", [CafeController::class, "get"])->name("cafe");
