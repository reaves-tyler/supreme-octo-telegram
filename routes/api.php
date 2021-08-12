<?php

use App\Http\Controllers\Api\Blackbook\BlackbookPowerSportsVIN;
use App\Http\Controllers\Api\Blackbook\BlackbookPowerSportsYMM;
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
    Route::post('/vehicle-valuation/blackbook/powersports/{vin}', BlackbookPowerSportsVIN::class);
    Route::post('/vehicle-valuation/blackbook/powersports/{year}/{make}/{model}', BlackbookPowerSportsYMM::class);
});

Route::resource('posts', PostController::class)->only([
    'destroy', 'show', 'store', 'update'
 ]);