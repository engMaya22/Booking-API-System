<?php

use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Business\ServiceController;
use App\Http\Controllers\ReviewsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::apiResource('user',UserController :: class);
Route::apiResource('business',BusinessController :: class);

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('service',ServiceController :: class);
    Route::apiResource('booking',BookingController :: class);
    Route::apiResource('review',ReviewsController :: class);
    Route::get('/{id}/reviews',[ReviewsController :: class , 'getReviews']);


});
