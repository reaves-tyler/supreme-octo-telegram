<?php

use App\Http\Controllers\Api\Blackbook\BlackbookPowerSportsVIN;
use App\Http\Controllers\Api\Blackbook\BlackbookPowerSportsUVC;
use App\Http\Controllers\Api\Blackbook\BlackbookPowerSportsYMM;
use App\Http\Controllers\Api\Blackbook\BlackbookRvUVC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ValidateAPIKey;
use App\Http\Controllers\PostController;
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

Route::get('/', function () {
    return 'Hello from the Laravel API!';
});
Route::middleware([ValidateAPIKey::class])->group(function () {
    Route::post('/vehicle-valuation/blackbook/powersports/VIN/{vin}', BlackbookPowerSportsVIN::class)->name('blackbook-powersports-vin');
    Route::post('/vehicle-valuation/blackbook/powersports/UVC/{uvc}', BlackbookPowerSportsUVC::class)->name('blackbook-powersports-uvc');
    Route::post('/vehicle-valuation/blackbook/powersports/{year}/{make}/{model}', BlackbookPowerSportsYMM::class)->name('blackbook-powersports-ymm');
    Route::post('/vehicle-valuation/blackbook/rv/UVC/{uvc}', BlackbookRvUVC::class)->name('blackbook-rv-uvc');
});

// routes only used for testing mongodb connection:
Route::resource('posts', PostController::class)->only([
    'destroy', 'show', 'store', 'update'
 ]);