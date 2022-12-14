<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\AuthentificationController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('pictures/store', [PictureController::class, 'store'])->middleware('App\Http\Middleware\ReactMiddleware');
Route::get('pictures/{id}', [PictureController::class, 'show'])->middleware('App\Http\Middleware\ReactMiddleware');
Route::post('pictures', [PictureController::class, 'search']);
Route::post('/login', [AuthentificationController::class, 'login']);
Route::post('/register', [AuthentificationController::class, 'register']);
