<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RestaurantController;


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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/token', function (Request $request) {
    $user = User::where('user_type', 'Admin')->first();
    $token = $user->createToken('test_token')->plainTextToken;
    return ['token' => $token];
});


Route::get('/getget',[MenuItemController::class , 'getget']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/students', [StudentController::class, 'index']);
    Route::post('/students', [StudentController::class, 'store']);
    Route::get('/students/{user}', [StudentController::class, 'show']);
    Route::put('/students/{user}', [StudentController::class, 'update']);
    Route::delete('/students/{user}', [StudentController::class, 'destroy']);
});




Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/restaurants', [RestaurantController::class, 'index']);
    Route::post('/restaurants', [RestaurantController::class, 'store']);
    Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show']);
    Route::put('/restaurants/{restaurant}', [RestaurantController::class, 'update']);
    Route::delete('/restaurants/{restaurant}', [RestaurantController::class, 'destroy']);
});

