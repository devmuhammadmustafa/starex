<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('login',[AuthController::class,'login']);

Route::group(['middleware' => ['auth:api']], function () {

    Route::post('/order/store',[OrderController::class,'store']);

});
