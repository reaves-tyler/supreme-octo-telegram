<?php

use App\Http\Controllers\Api\Blackbook\BlackbookPowerSportsVIN;
use App\Http\Controllers\Api\Blackbook\BlackbookPowerSportsUVC;
use App\Http\Controllers\Api\Blackbook\BlackbookPowerSportsYMM;
use App\Http\Controllers\Api\Blackbook\BlackbookRvUVC;
use App\Http\Controllers\Api\Blackbook\BlackbookRvYMM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ValidateAPIKey;
use App\Http\Controllers\PostController;
/*
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

Route::get('/', function () {
    return 'Hello from the Laravel API!';
});

Route::get('/hello', function () {
    return 'HELLO WEB.PHP!';
});


Route::middleware([ValidateAPIKey::class])->group(function () {
    Route::get('/vehicle-valuation/blackbook/powersports/VIN/{vin}', BlackbookPowerSportsVIN::class)->name('blackbook-powersports-vin');
    Route::get('/vehicle-valuation/blackbook/powersports/UVC/{uvc}', BlackbookPowerSportsUVC::class)->name('blackbook-powersports-uvc');
    Route::get('/vehicle-valuation/blackbook/powersports/{year}/{make}/{model}', BlackbookPowerSportsYMM::class)->name('blackbook-powersports-ymm');
    Route::get('/vehicle-valuation/blackbook/rv/UVC/{uvc}', BlackbookRvUVC::class)->name('blackbook-rv-uvc');
    Route::get('/vehicle-valuation/blackbook/rv/{year}/{make}/{model}/{style}', BlackbookRvYMM::class)->name('blackbook-rv-ymm');
});

// routes only used for testing mongodb connection:
Route::resource('posts', PostController::class)->only([
    'destroy', 'show', 'store', 'update'
]);
