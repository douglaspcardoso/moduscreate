<?php

namespace App\Clients;

use GuzzleHttp\Client;

class NHTSAClient
{

    /**
     * @var string
     */
    private $baseUri = 'https://one.nhtsa.gov/webapi/api/SafetyRatings/';
    /**
     * @var bool
     */
    private $defaultSSLVerification = false;
    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUri,
        ]);
    }

    /**
     * Get Vehicles from NHTSA API based on the given params
     *
     * @param $modelYear
     * @param $make
     * @param $model
     * @return mixed|string
     */
    public function findVehicles($modelYear, $make, $model)
    {
        $response = $this->client->request('GET', 'modelyear/'.$modelYear.'/make/'.$make.'/model/'.$model.'?format=json',
            ['verify' => $this->defaultSSLVerification]);

        return json_decode($response->getBody());
    }

    /**
     * Get the CrashRating for the given vehicle ID
     *
     * @param $vehicleId
     * @return string
     */
    public function getCrashRating($vehicleId)
    {
        // Get a response from NHTSA API through the call
        // GET https://one.nhtsa.gov/webapi/api/SafetyRatings/VehicleId/<VehicleId>?format=json
        $response = $this->client->request('GET', 'VehicleId/'.$vehicleId.'?format=json',
            ['verify' => $this->defaultSSLVerification]);

        // Get the first array item
        $vehicle = json_decode($response->getBody())->Results[0];

        // return the OverallRating
        return $vehicle->OverallRating;
    }

}