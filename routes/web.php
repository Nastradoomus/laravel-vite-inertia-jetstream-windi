<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(["auth:sanctum", "verified"])
    ->get("/dashboard", function () {
        return Inertia::render("Dashboard");
    })
    ->name("dashboard");

Route::middleware(["auth:sanctum", "verified"])
    ->prefix("restaurant")
    ->group(base_path("routes/service/restaurant.php"));

Route::middleware(["auth:sanctum", "verified"])
    ->prefix("cafe")
    ->group(base_path("routes/service/cafe.php"));

Route::middleware(["auth:sanctum", "verified"])
    ->prefix("portions")
    ->group(base_path("routes/service/portions.php"));

Route::middleware(["auth:sanctum", "verified"])
    ->prefix("servicehours")
    ->group(base_path("routes/service/servicehours.php"));

Route::middleware(["auth:sanctum", "verified"])
    ->prefix("defaults")
    ->group(base_path("routes/service/defaults.php"));


Route::get("/", function () {
    return Inertia::render("Auth/Login", ["canResetPassword" => true]);
});


/*
Route::get("/", function () {
    return Inertia::render("Auth/Register");
});
*/
