<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portions\PortionController;
use Inertia\Inertia;

// PORTIONS
Route::post("/authorized/portion", [PortionController::class, "post"]);

Route::delete("/authorized/portion", [PortionController::class, "delete"]);

Route::get("/authorized/search", [PortionController::class, "search"]);
Route::get("/authorized/check", [PortionController::class, "check"]);
Route::get("/authorized", [PortionController::class, "get"]);

Route::get("/", function () {
    return Inertia::render("Portions/Portions");
})
    ->name("portions");
