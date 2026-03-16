<?php

namespace App\Http\Controllers;

use App\Actions\InsurancePlansActions;
use App\Http\Requests\GetPlansRequest;
use App\Http\Requests\GetPlansSearchRequest;
use App\Http\Requests\GetPlanWithPremiumsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use phpseclib3\Math\PrimeField\Integer;

use OpenApi\Attributes as OA;

class InsurancePlansController extends Controller
{
    /**
     * @throws \Exception
     */
    #[
        OA\Post(
            path: '/api/v1/plans',
            description: 'Return List of Plans from the endpoint: <a href="https://developer.cms.gov/marketplace-api/api-spec#/Insurance%20Plans/post_plans" target="_blank">click here</a><br>
        exemple of successful call:
            <pre>
            {
                "household": {
                    "income": 20000,
                    "people": [
                    {
                        "age": 34,
                        "is_pregnant": false,
                        "is_parent": false,
                        "uses_tobacco": false,
                        "gender": "Male"
                    }
                    ],
                    "has_married_couple": false
                },
                "place": {
                    "countyfips": "51107",
                    "state": "VA",
                    "zipcode": "20103"
                },
                "market": "Individual",
                "plan_ids": [
                    "11512NC0100031"
                ],
                "year": 2019,
                "aptc_override": 100,
                "csr_override": "CSR73",
                "catastrophic_override": true
            }
            </pre>
        ',
            summary: 'List of Plans',
            tags: ['Plans']
        )
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
                mediaType: "application/json",
                schema: new OA\Schema('#/components/schemas/GetPlansRequest')
            )
        ]
    )]
    #[
        OA\Response(
            response: 200,
            description: 'List of plans',
            content: new OA\JsonContent(ref: '#/components/schemas/PlanCollection')
        )
    ]
    #[OA\Response(ref: '#/components/responses/401', response: 401)]
    #[OA\Response(ref: '#/components/responses/403', response: 403)]
    #[OA\Response(ref: '#/components/responses/404', response: 404)]
    #[OA\Response(
        response: 500,
        description: 'Json with Plans',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Plans list error response',
                        summary: 'Plans list error response',
                        value: [
                            'status' => 'error',
                            'data' => 'It was not possible to recover the plans list.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function plans(GetPlansRequest $request): JsonResponse
    {
        try {
            $plans = InsurancePlansActions::plans($request);
            return response()->json([
                'status' => 'success',
                'data' => $plans,
            ]);
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover the plans list.'
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    #[
        OA\Post(
            path: '/api/v1/plans/search',
            description: 'Return List of Plans from the endpoint: <a href="https://developer.cms.gov/marketplace-api/api-spec#/Insurance%20Plans/post_plans_search" target="_blank">click here</a><br>
        exemple of successful call:
            <pre>
            {
                "filter": {
                   "issuers": [],
                   "metal_levels": [],
                   "deductible": null,
                   "premium": null,
                   "drugs": ["1049589", "1100066", "1297390"] // Adicione aqui os RXCUIs
                },
                "household": {
                  "income": 42000,
                  "people": [
                    {
                      "aptc_eligible": true,
                      "dob": "1992-01-01",
                      "has_mec": false,
                      "is_pregnant": false,
                      "is_parent": false,
                      "uses_tobacco": false,
                      "gender": "Male",
                      "utilization_level": "Low"
                    }
                  ],
                  "has_married_couple": false
                },
                "market": "Individual",
                "place": {
                  "countyfips": "17031",
                  "state": "IL",
                  "zipcode": "60647"
                },
                "limit": 10,
                "offset": 0,
                "order": "asc",
                "year": 2020
            }
            </pre>
        ',
            summary: 'Search of Plans, can return pagination',
            tags: ['Plans']
        )
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
                mediaType: "application/json",
                schema: new OA\Schema('#/components/schemas/GetPlansSearchRequest')
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: 'List of plans',
        content: [
            new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'plans', type: "array", items: new OA\Items(ref: '#/components/schemas/Plan')),
                        new OA\Property(property: "total", type: "number", format: "integer"),
                        new OA\Property(property: "facet_groups", type: "array", items: new OA\Items(
                            properties: [
                                new OA\Property(property: "name", type: "string"),
                                new OA\Property(property: "facets", type: "array", items: new OA\Items(
                                    properties: [
                                        new OA\Property(property: "value", type: "string"),
                                        new OA\Property(property: "count", type: "number", format: 'integer'),
                                    ],
                                    type: "object"
                                ))
                            ],
                            type: "object"
                        )),
                        new OA\Property(
                            property: "rate_area",
                            properties: [
                                new OA\Property(property: "state", description: '2-letter USPS abbreviation', type: "string"),
                                new OA\Property(property: "area", description: 'Rate area number for the given state.', type: "number", format: 'integer'),
                            ],
                            type: "object"
                        ),
                        new OA\Property(
                            property: "ranges",
                            description: 'The lowest and highest values of premiums and deductibles of all the included plans are calculated and returned here. Premiums range is calculated from the premium_w_credit field',
                            properties: [
                                new OA\Property(
                                    property: "premiums",
                                    properties: [
                                        new OA\Property(property: "min", type: "number", format: 'float'),
                                        new OA\Property(property: "max", type: "number", format: 'float'),
                                    ],
                                    type: "object"
                                ),
                                new OA\Property(
                                    property: "deductibles",
                                    properties: [
                                        new OA\Property(property: "min", type: "number", format: 'float'),
                                        new OA\Property(property: "max", type: "number", format: 'float'),
                                    ],
                                    type: "object"
                                ),
                            ],
                            type: "object"
                        ),
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    #[OA\Response(ref: '#/components/responses/401', response: 401)]
    #[OA\Response(ref: '#/components/responses/403', response: 403)]
    #[OA\Response(ref: '#/components/responses/404', response: 404)]
    #[OA\Response(
        response: 500,
        description: 'Json with Plans',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Plans list error response',
                        summary: 'Plans list error response',
                        value: [
                            'status' => 'error',
                            'data' => 'It was not possible to recover the plans search list.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function plansSearch(GetPlansSearchRequest $request): JsonResponse
    {
        try {
            $plans = InsurancePlansActions::plansSearch($request);
            return response()->json([
                'status' => 'success',
                'data' => $plans,
            ]);
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover the plans search list.'
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    #[
        OA\Post(
            path: '/api/v1/plans/search/stats',
            description: 'Retrieve stats (avg premium, oopc, etc) on a group of insurance plans. The input is identical to /plans/search, but the return value does not contain any actual plan data. Endpoint: <a href="https://developer.cms.gov/marketplace-api/api-spec#/Insurance%20Plans/post_plans_search_stats" target="_blank">click here</a><br>
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
            summary: 'Retrieve stats (avg premium, oopc, etc) on a group of insurance plans.',
            tags: ['Plans']
        )
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
                mediaType: "application/json",
                schema: new OA\Schema('#/components/schemas/GetPlansRequest')
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: 'List of plans stats',
        content: [
            new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: "metal_level", type: "string", enum: ["Catastrophic", "Silver", "Bronze", "Gold", "Platinum"]),
                        new OA\Property(property: "premium", type: "number", format: "float"),
                        new OA\Property(property: "simple_choice", description: 'The number of simple choice plans available', type: 'number', format: 'integer'),
                        new OA\Property(
                            property: "premiums",
                            properties: [
                                new OA\Property(property: "min", type: "number", format: 'float', nullable: true),
                                new OA\Property(property: "max", type: "number", format: 'float', nullable: true),
                                new OA\Property(property: "mean", type: "number", format: 'float', nullable: true)
                            ],
                            type: 'object'
                        ),
                        new OA\Property(
                            property: "oopc",
                            properties: [
                                new OA\Property(property: "min", type: "number", format: 'float', nullable: true),
                                new OA\Property(property: "max", type: "number", format: 'float', nullable: true),
                                new OA\Property(property: "mean", type: "number", format: 'float', nullable: true)
                            ],
                            type: 'object'
                        ),
                        new OA\Property(
                            property: "quality_ratings",
                            description: 'Quality ratings will not always be available',
                            properties: [
                                new OA\Property(property: "five_star_rating", type: "number", format: 'float', nullable: true),
                                new OA\Property(property: "four_star_rating", type: "number", format: 'float', nullable: true),
                                new OA\Property(property: "three_star_rating", type: "number", format: 'float', nullable: true),
                                new OA\Property(property: "two_star_rating", type: "number", format: 'float', nullable: true),
                                new OA\Property(property: "one_star_rating", type: "number", format: 'float', nullable: true)
                            ],
                            type: 'object'
                        ),
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    #[OA\Response(ref: '#/components/responses/401', response: 401)]
    #[OA\Response(ref: '#/components/responses/403', response: 403)]
    #[OA\Response(ref: '#/components/responses/404', response: 404)]
    #[OA\Response(
        response: 500,
        description: 'Json with Plans',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Plans stats list error response',
                        summary: 'Plans stats list error response',
                        value: [
                            'status' => 'error',
                            'data' => 'It was not possible to recover the plans search stats list.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function plansSearchStats(GetPlansSearchRequest $request): JsonResponse
    {
        try {
            $plans = InsurancePlansActions::plansSearchStats($request);
            return response()->json([
                'status' => 'success',
                'data' => $plans,
            ]);
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover the plans search stats list.'
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    #[
        OA\Get(
            path: '/api/v1/plans/{plan_id}',
            description: 'Get a plan\'s basic details, no premium or APTC calculated. Endpoint: <a href="https://developer.cms.gov/marketplace-api/api-spec#/Insurance%20Plans/get_plans__plan_id_" target="_blank">click here</a><br>',
            summary: 'Get a plan\'s basic details, no premium or APTC calculated.',
            tags: ['Plans']
        )
    ]
    #[OA\Parameter(
        name: 'plan_id',
        description: '14-character HIOS plan ID',
        in: 'path'
    )]
    #[OA\QueryParameter(
        name: 'year',
        description: '4 digit market year (Defaults to the current year when not specified)',
        in: 'query',
        required: false,
        allowEmptyValue: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Response(
        response: 200,
        description: 'Plan object',
        content: [
            new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'plan', ref: '#/components/schemas/Plan')
                    ],
                )
            )
        ]
    )]
    #[OA\Response(ref: '#/components/responses/401', response: 401)]
    #[OA\Response(ref: '#/components/responses/403', response: 403)]
    #[OA\Response(ref: '#/components/responses/404', response: 404)]
    #[OA\Response(
        response: 500,
        description: 'Json with Plans',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Plan error response',
                        summary: 'Plan error response',
                        value: [
                            'status' => 'error',
                            'data' => 'It was not possible to recover the plan by it\'s id.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function plan(Request $request, $plan_id): JsonResponse
    {
        try {
            $plan = InsurancePlansActions::getPlan($plan_id, $request);
            return response()->json([
                'status' => 'success',
                'data' => $plan,
            ]);
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover the plan by it\'s id.'
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    #[
        OA\Post(
            path: '/api/v1/plans/{plan_id}',
            description: 'Get a plan\'s basic details, no premium or APTC calculated. Endpoint: <a href="https://developer.cms.gov/marketplace-api/api-spec#/Insurance%20Plans/get_plans__plan_id_" target="_blank">click here</a><br>',
            summary: 'Get a plan\'s basic details, no premium or APTC calculated.',
            tags: ['Plans']
        )
    ]
    #[OA\Parameter(
        name: 'plan_id',
        description: '14-character HIOS plan ID',
        in: 'path'
    )]
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
                mediaType: "application/json",
                schema: new OA\Schema('#/components/schemas/GetPlanWithPremiumsRequest')
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: 'Plan object',
        content: [
            new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'plan', ref: '#/components/schemas/Plan'),
                        new OA\Property(property: 'rate_area', ref: '#/components/schemas/RateArea'),
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    #[OA\Response(ref: '#/components/responses/401', response: 401)]
    #[OA\Response(ref: '#/components/responses/403', response: 403)]
    #[OA\Response(ref: '#/components/responses/404', response: 404)]
    #[OA\Response(
        response: 500,
        description: 'Json with Plans',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Plan error response',
                        summary: 'Plan error response',
                        value: [
                            'status' => 'error',
                            'data' => 'It was not possible to recover the plan by it\'s id.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function planWithPremiums(GetPlanWithPremiumsRequest $request, $plan_id): JsonResponse
    {
        try {
            $data = InsurancePlansActions::getPlanWithPremiums($plan_id, $request);
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover the plan by it\'s id.'
            ], 500);
        }
    }

    public function getAllCoveredDrugs(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $endpoint = 'drugs/covered';
        $token = config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
        $url = config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL") . $endpoint;
        $params = [
            'query' => [
                'apikey' => $token,
                'year' => $year,
            ]
        ];

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode >= 200 && $statusCode < 300) {
                return response()->json(json_decode($body));
            } else {
                Log::error('Falha ao obter medicamentos cobertos: ' . $statusCode . ' - ' . $body);
                return response()->json(['error' => 'Falha ao obter medicamentos cobertos'], $statusCode);
            }
        } catch (\GuzzleHttp\Exception\GuzzleException | \Exception $e) {
            Log::error('Falha ao obter medicamentos cobertos: ' . $e->getMessage());
            return response()->json(['error' => 'Falha ao obter medicamentos cobertos'], 500);
        }
    }


    /**
     * @throws \Exception
     */
    #[
        OA\Get(
            path: '/api/v1/drugs/autocomplete',
            description: 'Autocomplete for drugs. Endpoint: <a href="https://developer.cms.gov/marketplace-api/api-spec#/Provider%20%26%20Drug%20Coverage/get_drugs_autocomplete" target="_blank">click here</a>',
            summary: 'Autocomplete for drugs',
            tags: ['Drugs']
        )
    ]
    #[OA\QueryParameter(
        name: 'q',
        description: 'Query string for the drug autocomplete',
        in: 'query',
        required: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Response(
        response: 200,
        description: 'List of drugs',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'drugs', type: 'array', items: new OA\Items(
                    properties: [
                        new OA\Property(property: 'rxcui', type: 'string'),
                        new OA\Property(property: 'name', type: 'string'),
                        new OA\Property(property: 'strength', type: 'string'),
                        new OA\Property(property: 'route', type: 'string'),
                        new OA\Property(property: 'full_name', type: 'string'),
                        new OA\Property(property: 'rxterms_dose_form', type: 'string'),
                        new OA\Property(property: 'rxnorm_dose_form', type: 'string'),
                    ],
                    type: 'object'
                )),
            ],
            type: 'object'
        )
    )]
    #[OA\Response(ref: '#/components/responses/401', response: 401)]
    #[OA\Response(ref: '#/components/responses/403', response: 403)]
    #[OA\Response(ref: '#/components/responses/404', response: 404)]
    #[OA\Response(
        response: 500,
        description: 'Error response',
        content: new OA\JsonContent(
            examples: [
                new OA\Examples(
                    example: 'Drugs autocomplete error response',
                    summary: 'Drugs autocomplete error response',
                    value: [
                        'status' => 'error',
                        'message' => 'It was not possible to get the drugs autocomplete.'
                    ]
                ),
            ],
            discriminator: new OA\Discriminator('response',)
        )
    )]
    public function getDrugsAutocomplete(Request $request): JsonResponse
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json([
                'status' => 'error',
                'message' => 'Query parameter "q" is required.'
            ], 400);
        }

        try {
            $drugs = InsurancePlansActions::getDrugsAutocomplete($query);
            return response()->json([
                'status' => 'success',
                'data' => $drugs,
            ]);
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to get the drugs autocomplete.'
            ], 500);
        }
    }
    #[OA\Get(
        path: '/api/v1/plans/providers/autocomplete',
        description: 'Autocomplete for providers. Endpoint: <a href="https://developer.cms.gov/marketplace-api/api-spec#/Provider%20%26%20Drug%20Coverage/get_providers_autocomplete" target="_blank">click here</a>',
        summary: 'Autocomplete for providers',
        tags: ['Providers']
    )]
    #[OA\QueryParameter(
        name: 'q',
        description: 'Query string for the provider autocomplete (minimum 3 characters)',
        in: 'query',
        required: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\QueryParameter(
        name: 'zipcode',
        description: '5-digit US zipcode',
        in: 'query',
        required: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Response(
        response: 200,
        description: 'List of providers',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'providers',
                    type: 'array',
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: 'name', type: 'string'),
                            new OA\Property(property: 'gender', type: 'string'),
                            new OA\Property(
                                property: 'specialties',
                                type: 'array',
                                items: new OA\Items(type: 'string')
                            ),
                            new OA\Property(property: 'type', type: 'string'),
                            new OA\Property(property: 'accepting', type: 'string'),
                            new OA\Property(property: 'npi', type: 'string'),
                            new OA\Property(
                                property: 'languages',
                                type: 'array',
                                items: new OA\Items(type: 'string')
                            ),
                            new OA\Property(
                                property: 'facility_types',
                                type: 'array',
                                items: new OA\Items(type: 'string')
                            ),
                            new OA\Property(property: 'taxonomy', type: 'string'),
                        ],
                        type: 'object'
                    )
                )
            ],
            type: 'object'
        )
    )]
    #[OA\Response(ref: '#/components/responses/401', response: 401)]
    #[OA\Response(ref: '#/components/responses/403', response: 403)]
    #[OA\Response(ref: '#/components/responses/404', response: 404)]
    #[OA\Response(
        response: 500,
        description: 'Error response',
        content: new OA\JsonContent(
            examples: [
                new OA\Examples(
                    example: 'Providers autocomplete error response',
                    summary: 'Providers autocomplete error response',
                    value: [
                        'status' => 'error',
                        'message' => 'It was not possible to get the providers autocomplete.'
                    ]
                )
            ],
            discriminator: new OA\Discriminator('response')
        )
    )]
    public function getProvidersAutocomplete(Request $request): JsonResponse
    {
        // Utilize "q" para a busca, conforme a API exige, e "zipcode" para o zipcode
        $query   = $request->input('q');
        $zipcode = $request->input('zipcode');

        if (!$query) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Query parameter "q" is required.'
            ], 400);
        }

        if (!$zipcode) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Query parameter "zipcode" is required.'
            ], 400);
        }

        try {
            $providers = InsurancePlansActions::getProvidersAutocomplete($query, $zipcode);
            return response()->json([
                'status' => 'success',
                'data'   => $providers,
            ]);
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'It was not possible to get the providers autocomplete.'
            ], 500);
        }
    }
}
