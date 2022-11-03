<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::group(['prefix'=>'panel'], function(){
    Route::post('login', [AuthController::class, 'login']);
});

Route::group(['prefix'=>'panel', 'middleware'=>'auth:sanctum'], function(){
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
