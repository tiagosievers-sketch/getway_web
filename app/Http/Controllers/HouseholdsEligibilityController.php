<?php

namespace App\Http\Controllers;

use App\Actions\HouseholdsEligibilityActions;
use App\Http\Requests\GetHouseholdEligibilityEstimatesRequest;
use App\Http\Requests\GetHouseholdSlcspRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

use OpenApi\Attributes as OA;

class HouseholdsEligibilityController extends Controller
{
    /**
     * @throws \Exception
     */
    #[OA\Post(
        path: '/api/v1/households-elegibility/estimates',
        description: 'Create an eligibility estimate for a household. Index of each object in response array is index into Household.people array: i.e., that eligibility estimate is for that person. Endpoint: <a href="https://developer.cms.gov/marketplace-api/api-spec#/Households%20%26%20Eligibility/post_households_eligibility_estimates" target="_blank">click here</a><br>
        exemple of successful call:
            <pre>
            {
                "household": {
                "income": 52000,
                "people": [
                  {
                      "dob": "1992-01-01",
                      "aptc_eligible": true,
                   "gender": "Female",
                    "uses_tobacco": false
                   }
                 ]
                },
                "market": "Individual",
                "place": {
                   "countyfips": "37057",
                   "state": "NC",
                    "zipcode": "27360"
                },
                "year": 2019
            }
            </pre>
        ',
        summary: 'Create an eligibility estimate for a household.',
        tags: ['Households & Eligibility'])
    ]
    #[OA\QueryParameter(
        name: 'year',
        description: '4 digit market year (Defaults to the current year when not specified)',
        in: 'query',
        required: false,
        allowEmptyValue: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\RequestBody(
        description: 'Send a body with information for the requisition.',
        required: true,
        content: [
            new OA\MediaType(
                mediaType: "application/json" ,
                schema: new OA\Schema('#/components/schemas/GetHouseholdEligibilityEstimatesRequest')
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: 'Array of Eligibility objects',
        content: [
            new OA\MediaType(
                mediaType: "application/json" ,
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property:"status",type: 'string', enum: ['success','error']),
                        new OA\Property(
                            property:"data",
                            properties: [
                                new OA\Property(
                                    property:"estimates",
                                    type:"array",
                                    items: new OA\Items(ref: '#/components/schemas/Eligibility')
                                )
                            ],
                            type:"object",
                        ),
                    ]
                )
            )
        ]
    )]
    #[OA\Response(ref: '#/components/responses/401', response: 401)]
    #[OA\Response(ref: '#/components/responses/403', response: 403)]
    #[OA\Response(ref: '#/components/responses/404', response: 404)]
    #[OA\Response(
        response: 500,
        description: 'Json with Providers Coverage',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Plan error response',
                        summary: 'Plan error response',
                        value: [
                            'status' => 'error',
                            'data' => 'It was not possible to recover the estimates.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function estimates(GetHouseholdEligibilityEstimatesRequest $request): JsonResponse
    {
        try {
            $data = HouseholdsEligibilityActions::getEstimates($request);
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        } catch ( \Exception $e) {
            Log::error('Exception: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover the estimates.'
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    #[OA\Post(
        path: '/api/v1/households-elegibility/slcsp',
        description: 'Get the second lowest cost silver plan for a household. Response is a plan object with the premium set to the rate for the household.<br>
        Note -- when calculating the SLCSP for a household that has members in different rating areas, the household must be split by rating area and multiple SLCSP requests must be sent, with the results summed at the end (applies only to 2019 ratings).<br> Endpoint: <a href="https://developer.cms.gov/marketplace-api/api-spec#/Households%20%26%20Eligibility/post_households_slcsp" target="_blank">click here</a><br>
        exemple of successful call:
            <pre>
            {
                "household": {
                  "income": 52000,
                  "people": [
                  {
                      "dob": "1992-01-01",
                      "aptc_eligible": true,
                      "gender": "Female",
                      "uses_tobacco": false
                   }
                 ]
                },
                "market": "Individual",
                "place": {
                   "countyfips": "37057",
                   "state": "NC",
                   "zipcode": "27360"
                },
                "year": 2020
            }
            </pre>
        ',
        summary: 'Get the second lowest cost silver plan for a household.',
        tags: ['Households & Eligibility'])
    ]
    #[OA\QueryParameter(
        name: 'year',
        description: '4 digit market year (Defaults to the current year when not specified)',
        in: 'query',
        required: false,
        allowEmptyValue: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\RequestBody(
        description: 'Send a body with information for the requisition.',
        required: true,
        content: [
            new OA\MediaType(
                mediaType: "application/json" ,
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property:"status",type: 'string', enum: ['success','error']),
                        new OA\Property(
                            property:"data",
                            properties: [
                                new OA\Property(
                                    property:"estimates",
                                    type:"array",
                                    items: new OA\Items(ref: '#/components/schemas/Eligibility')
                                )
                            ],
                            type:"object",
                        ),
                    ]
                )
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: 'Lowest Cost Plan object',
        content: [
            new OA\MediaType(
                mediaType: "application/json",
//                schema: new OA\Schema(ref: '#/components/schemas/LowestCostPlan')
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property:"status",type: 'string', enum: ['success','error']),
                        new OA\Property(
                            property:"data",
                            ref: '#/components/schemas/LowestCostPlan'
                        ),
                    ]
                )
            )
        ]
    )]
    #[OA\Response(ref: '#/components/responses/401', response: 401)]
    #[OA\Response(ref: '#/components/responses/403', response: 403)]
    #[OA\Response(ref: '#/components/responses/404', response: 404)]
    #[OA\Response(
        response: 500,
        description: 'Json with Providers Coverage',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Plan error response',
                        summary: 'Plan error response',
                        value: [
                            'status' => 'error',
                            'data' => 'It was not possible to recover the slcsp.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function slcsp(GetHouseholdSlcspRequest $request): JsonResponse
    {
        try {
            $data = HouseholdsEligibilityActions::getSlcsp($request);
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        } catch ( \Exception $e) {
            Log::error('Exception: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover the slcsp.'
            ], 500);
        }
    }
}
