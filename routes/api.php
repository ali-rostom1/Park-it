<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SpotController;
use App\Models\Reservation;
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


Route::apiResource('reservations',ReservationController::class)->middleware(['auth:sanctum','role:admin']);

Route::get('search-spots/{term}',[ParkingController::class,'searchSpots'])->middleware('auth:sanctum');

Route::get('cancel-reservation/{reservation}',[ReservationController::class,'cancelMyReservation'])->middleware('auth:sanctum');

Route::get('my-reservations',[ReservationController::class,'myReservations'])->middleware('auth:sanctum');



Route::get('test',function(){
    return response()->json('hello');
})->middleware(['auth:sanctum','role:user']);