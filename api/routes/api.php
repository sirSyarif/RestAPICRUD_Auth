<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\VaksinController;

Route::post('login', [ApiController::class, 'authenticate']);
Route::post('register', [ApiController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('get_user', [ApiController::class, 'get_user']);
    Route::get('products', [VaksinController::class, 'index']);
    Route::get('products/{id}', [VaksinController::class, 'show']);
    Route::post('create', [VaksinController::class, 'store']);
    Route::put('update/{product}',  [VaksinController::class, 'update']);
    Route::delete('delete/{product}',  [VaksinController::class, 'destroy']);
});