<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use App\Http\Requests\FARSRequest;
use App\Services\FarsService;
use Exception;

class FARSController extends Controller
{
    protected $farsService;

    public function __construct(FarsService $farsService)
    {
        $this->farsService = $farsService;
    }

    public function submit(FARSRequest $request)
    {
        try {
            // The validated data from the FARSRequest
            $farsData = $request->validated();

            // Call the FARS service to submit the fraud report
            $response = $this->farsService->submitFraudReport($farsData);

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
