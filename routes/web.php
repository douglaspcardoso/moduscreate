<?php

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

Route::group(['prefix' => 'vehicles'], function () {
    // POST http://localhost:8080/api/vehicles
    Route::post('/', 'VehicleController@getVehiclesByPostRequest');

    // GET http://localhost:8080/api/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL>
    Route::get('{modelYear}/{manufacturer}/{model}', 'VehicleController@getVehicles');
});