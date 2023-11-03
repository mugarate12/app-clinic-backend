<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Enums\AuthenticationUserAbilitiesEnum;

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

define('isAdmin', AuthenticationUserAbilitiesEnum::Admin->value);
const onlyAdmin = ['auth:sanctum', "ability:" . isAdmin];

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// AUTHENTICATION ROUTES
Route::post('/login', [AuthController::class, 'login']);

// USER ROUTES
Route::middleware(onlyAdmin)->group(function () {
    Route::post('/users/admin', [UserController::class, 'storeNewAdmin']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);

    Route::post('/users/with_key', [UserController::class, 'storeUserWithKey']);

    Route::put('/users/{id}', [UserController::class, 'update']);
});

Route::put('/users/with_key/{key}', [UserController::class, 'updateWithKey']);
