<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Api\UserApiController;


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

Route::post("register",[UserApiController::class, "register"]);
Route::post("login",[UserApiController::class, "login"]);

Route::group(["middleware"=>["api"]], function(){
    //user api
Route::get("profile", [UserApiController::class, "profile"]);
    // Api route
Route::get("total-orders",[OrderApiController::class, "totalOrders"]); 
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
