<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use App\Http\Requests\RIDPRequest;
use App\Services\RidpService;
use Exception;

class RIDPController extends Controller
{
    protected $ridpService;

    public function __construct(RidpService $ridpService)
    {
        $this->ridpService = $ridpService;
    }

    public function initiate(RIDPRequest $request)
    {
        try {
            // The validated data from the RIDPRequest
            $ridpData = $request->validated();

            // Call the RIDP service to initiate the RIDP process
            $response = $this->ridpService->initiateRidp($ridpData);

            return response()->json([
                'status' => 'success',
                'data' => $response,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
