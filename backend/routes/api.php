<?php

use App\Http\Controllers\api\GameController;
use App\Http\Controllers\api\GameDsController;
use App\Http\Controllers\api\KeyController;
use App\Http\Controllers\api\RobloxController;
use App\Http\Controllers\api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Open routes
Route::post('/register', [ApiController::class, 'register']);
Route::post('/login', [ApiController::class, 'login']);
Route::get('/roblox-data', [RobloxController::class, 'getDatastores']);



// Protected routes
Route::group([
    "middleware" => "auth:api"
], function (){
    Route::get('/profile', [ApiController::class, 'profile']);
    Route::get('/logout', [ApiController::class, 'logout']);
    Route::apiResource('game', GameController::class);
    Route::apiResource('game_ds', GameDsController::class);
    Route::apiResource('key', KeyController::class);
});
