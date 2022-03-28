<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\RecorderController;
use App\Http\Controllers\PredictController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{word?}', [RecorderController::class, 'index']);
Route::post('/store', [UploadController::class, 'index']);
Route::get('/predict', [PredictController::class, 'index']);
Route::post('/predict', [PredictController::class, 'predict']);
