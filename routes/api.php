<?php

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

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {

    Route::prefix('ceo')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\CEOController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\CEOController::class, 'store']);
        Route::get('/{ceo}', [\App\Http\Controllers\Api\CEOController::class, 'show']);
        Route::put('/{ceo}', [\App\Http\Controllers\Api\CEOController::class, 'update']);
        Route::delete('/{ceo}', [\App\Http\Controllers\Api\CEOController::class, 'delete']);
    });
});
