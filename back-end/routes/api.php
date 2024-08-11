<?php

use App\Http\Controllers\TanaInonderController;
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
Route::get('/tana-inonder', [TanaInonderController::class, 'index']);
Route::get('/tana-inonder/markers', [TanaInonderController::class, 'getMarkers']);
Route::get('/tana-inonder/markers/{dangerLevel}', [TanaInonderController::class, 'getMarkers']);
Route::get('/tana-inonder/fokontany/{fokontany}', [TanaInonderController::class, 'getFokontanyCoordinates']);

