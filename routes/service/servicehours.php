<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceHours\ServiceHourController;
use Inertia\Inertia;

// SERVICE HOURS

Route::get("/", [serviceHourController::class, "get"])->name("servicehours");
Route::post("/authorized/servicehour", [ServiceHourController::class, "post"]);
