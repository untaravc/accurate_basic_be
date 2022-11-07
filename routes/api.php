<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;

Route::group(['prefix'=>'panel'], function(){
    Route::post('login', [AuthController::class, 'login']);
});

Route::group(['prefix'=>'panel', 'middleware'=>'auth:sanctum'], function(){
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('auth', [AuthController::class, 'auth']);

    // CRUD
    Route::resource('products', ProductController::class);

});
