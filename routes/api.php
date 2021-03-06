<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(
    [
        'prefix' => 'auth',

    ], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);
    }
);

Route::group(
    [
        'prefix' => 'admin/inventory',

    ], function () {
        Route::post('/create', [InventoryController::class, 'store']);
        Route::get('/list', [InventoryController::class, 'index']);
        Route::get('/read/{inventory}', [InventoryController::class, 'show']);
        Route::put('/update/{inventoryId}', [InventoryController::class, 'update']);
        Route::delete(
            '/destroy/{inventoryId}', [
                InventoryController::class,
                'destroy']
        );

    }
);

Route::group(
    [
        'prefix' => 'user/inventory',

    ], function () {
        Route::get('/list', [UserController::class, 'listInventories']);
        Route::get('/read/{inventory}', [UserController::class, 'readInventory']);
        Route::post(
            '/add-to-cart/{inventoryId}', [
                UserController::class,
                'addInventoryToCart']
        );

    }
);
