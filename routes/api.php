<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ShoppingController;
use App\Http\Controllers\Api\UserController;
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

Route::post('users/signup', [AuthController::class, 'signup']);
Route::post('users/signin', [AuthController::class, 'signin']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('users', [UserController::class, 'getUsers']);

    Route::post('shoppings', [ShoppingController::class, 'store']);
    Route::get('shoppings', [ShoppingController::class, 'getShoppings']);
    Route::get('shoppings/{id}', [ShoppingController::class, 'show']);
    Route::put('shoppings/{id}', [ShoppingController::class, 'update']);
    Route::delete('shoppings/{id}', [ShoppingController::class, 'destroy']);
});
