<?php

use App\Http\Controllers\Api\Blackbook\Blackbook;
use App\Http\Controllers\Api\Blackbook\BlackbookYMM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VehicleValuation;

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

Route::get('/vehicle-valuation', VehicleValuation::class);
Route::post('/vehicle-valuation/blackbook', Blackbook::class);
Route::post('/vehicle-valuation/blackbook/{year}/{make}/{model}', BlackbookYMM::class)->whereNumber('year')->whereAlpha('make')->whereAlphaNumeric('model');
