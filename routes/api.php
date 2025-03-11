<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\SpotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout'])
  ->middleware('auth:sanctum');

Route::apiResource('parkings',ParkingController::class)->only("index",'show')->middleware('auth:sanctum');
Route::apiResource('parkings',ParkingController::class)->except("index",'show')->middleware(['auth:sanctum','role:admin']);

Route::apiResource('spots',SpotController::class)->only("index",'show')->middleware('auth:sanctum');
Route::apiResource('spots',SpotController::class)->except("index",'show')->middleware(['auth:sanctum','role:admin']);

Route::get('test',function(){
    return response()->json('hello');
})->middleware(['auth:sanctum','role:user']);