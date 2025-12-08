<?php

use App\Http\Controllers\v1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix("v1")->group(function(){
    Route::prefix("users")->group(function(){
        Route::get("login", [AuthController::class, "login"]);
        Route::post("register", [AuthController::class, "register"]);
        Route::patch("changePassword", [AuthController::class, "changePassword"]);
        Route::patch("changeInfo", [AuthController::class, "changeInfo"]);
    });
});
