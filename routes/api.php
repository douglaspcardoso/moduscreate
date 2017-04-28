<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'vehicles'], function () {
    // POST http://localhost:8080/api/vehicles
    Route::post('/', 'VehicleController@getVehiclesByPostRequest');

    // GET http://localhost:8080/api/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL>
    Route::get('{modelYear}/{manufacturer}/{model}', 'VehicleController@getVehicles');
});