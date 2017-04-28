<?php

namespace App\Http\Controllers;

use App\Services\VehicleService;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * @var VehicleService
     */
    private $service;

    public function __construct(VehicleService $vehicleService)
    {
        $this->service = $vehicleService;
    }

    /**
     * Display a list of vehicle based on the URL params.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVehicles(Request $request)
    {
        // Verify URL param withRating, if string value is 'true', set true otherwise, false
        $withRating = ($request->get('withRating') === 'true' ? true : false);

        // Call Service layer to handle data from the NHTSA API passing the params
        $vehicles = $this->service->findVehicles([
            'modelYear' => $request->route('modelYear'),
            'make' => $request->route('manufacturer'),
            'model' => $request->route('model'),
        ], $withRating);

        // Return the JSON response
        return response()->json($vehicles);
    }

    /**
     * Display a listing of vehicles based on the form params.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVehiclesByPostRequest(Request $request)
    {
        // Verify URL param withRating, if string value is 'true', set true otherwise, false
        $withRating = ($request->get('withRating') === 'true' ? true : false);

        // Call Service layer to handle data from the NHTSA API passing the params
        $vehicles = $this->service->findVehicles([
            'modelYear' => $request->get('modelYear'),
            'make' => $request->get('manufacturer'),
            'model' => $request->get('model'),
        ], $withRating);

        // Return the JSON response
        return response()->json($vehicles);
    }
}
