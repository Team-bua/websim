<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/order/{id}/user/{token}',[ApiController::class,'getOrder']);
Route::get('/get-phone/{order_id}',[ApiController::class,'getPhone']);
Route::get('/get-otp/{phone_number}',[ApiController::class,'getOtp']);
Route::get('/check-order',[ApiController::class,'checkOrder']);
Route::get('/add-phone',[ApiController::class,'updatePhone']);
Route::get('/check-code',[ApiController::class,'checkCode']);

Route::get('/check-expired',[ApiController::class,'checkExpired']);

Route::get('/add-code',[ApiController::class,'updateCode']);

