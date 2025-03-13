<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SpotController;
use App\Http\Controllers\StatisticsController;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::middleware(['auth:sanctum','role:admin'])->group(function(){

    Route::apiResource('parkings',ParkingController::class)->except("index",'show');

    Route::apiResource('spots',SpotController::class)->except("index",'show');


    Route::apiResource('reservations',ReservationController::class);

});




Route::middleware('auth:sanctum')->group(function(){
    Route::get('search-spots/{term}',[ParkingController::class,'searchSpots']);

    Route::get('cancel-reservation/{reservation}',[ReservationController::class,'cancelMyReservation']);

    Route::get('my-reservations',[ReservationController::class,'myReservations']);

    Route::apiResource('spots',SpotController::class)->only("index",'show');

    Route::apiResource('parkings',ParkingController::class)->only("index",'show');
    
    Route::get('statistics',StatisticsController::class);

    Route::post('logout',[AuthController::class,'logout']);
});



Route::get('test',function(){
    return response()->json('hello');
})->middleware(['auth:sanctum','role:user']);