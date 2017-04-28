<?php

namespace App\Services;

use App\Clients\NHTSAClient;
use Illuminate\Support\Facades\Validator;

class VehicleService
{

    /**
     * @var NHTSAClient
     */
    private $client;

    public function __construct(NHTSAClient $client)
    {
        $this->client = $client;
    }

    /**
     * Look at the NHTSA API for vehicles
     *
     * @param array $params
     * @param bool $withRating
     * @return array
     */
    public function findVehicles(array $params, $withRating = false)
    {
        // If a required param is not set, return Count = 0, Results = []
        $validator = Validator::make($params, [
            'modelYear' => 'required',
            'make' => 'required',
            'model' => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'Count' => 0,
                'Results' => []
            ];
        }

        // Get the vehicles from NHTSA API
        try {
            $data = $this->client->findVehicles($params['modelYear'], $params['make'], $params['model']);
        } catch (\Exception $e) {
            return [
                'Count' => 0,
                'Results' => []
            ];
        }

        // Format the result before to back to Controller
        return $this->formatJsonOutput($data, $withRating);
    }

    /**
     * Format the output to Controller
     *
     * @param $jsonResponse
     * @param $withRating
     * @return array
     */
    public function formatJsonOutput($jsonResponse, $withRating)
    {
        // If response returns 0 results, then format output and return
        if ($jsonResponse->Count === 0) {
            return [
                'Count' => 0,
                'Results' => []
            ];
        }

        // Prepare the output array
        $output = [
            'Count' => $jsonResponse->Count,
            'Results' => []
        ];

        // If $withRating = true, then add CrashRating param to the output array
        if ($withRating) {
            foreach ($jsonResponse->Results as $result) {
                $output['Results'][] = [
                    'CrashRating' => $this->client->getCrashRating($result->VehicleId),
                    'Description' => $result->VehicleDescription,
                    'VehicleId' => $result->VehicleId
                ];
            }
        } else {
            foreach ($jsonResponse->Results as $result) {
                $output['Results'][] = [
                    'Description' => $result->VehicleDescription,
                    'VehicleId' => $result->VehicleId
                ];
            }
        }

        return $output;
    }
}