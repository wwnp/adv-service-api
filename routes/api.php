<?php

use App\Http\Controllers\AdvertisementController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('advertisements', [AdvertisementController::class, "index"]);
Route::get('advertisements/{id}', [AdvertisementController::class, "show"]);
Route::post('advertisements', [AdvertisementController::class, "store"]);
