<?php

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\BasketController;
use App\Http\Controllers\v1\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix("v1")->group(function(){
    Route::prefix("users")->group(function(){
        Route::get("login", [AuthController::class, "login"]);
        Route::post("register", [AuthController::class, "register"]);
        Route::patch("changePassword", [AuthController::class, "changePassword"]);
        Route::patch("changeInfo", [AuthController::class, "changeInfo"]);
    });

    Route::prefix("products")->group(function(){
        Route::get("get", [ProductsController::class, "readProducts"]);
        Route::post("insert", [ProductsController::class, "insertProducts"]);
        Route::post("update", [ProductsController::class, "updateProducts"]);
        Route::delete("delete", [ProductsController::class, "deleteProducts"]);
    });

    Route::prefix("basket")->group(function(){
        Route::get("get", [BasketController::class, "readBasket"]);
        Route::post("insert", [BasketController::class, "insertBasket"]);
        Route::delete("delete", [BasketController::class, "deleteBasket"]);
        Route::patch("update", [BasketController::class, "updateBasket"]);
    });
});
