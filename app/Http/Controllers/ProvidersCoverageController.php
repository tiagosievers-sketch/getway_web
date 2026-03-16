<?php

namespace App\Http\Controllers;

use App\Actions\ProvidersCoverageActions;
use App\Http\Requests\GetProvidersCoverageRequest;
use Illuminate\Http\Resources\Json\JsonResource;

use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

class ProvidersCoverageController extends Controller
{
    /**
     * @throws \Exception
     */
    #[OA\Get(
        path: '/api/v1/provider/coverage',
        description: 'Return Providers Coverage from the endpoint: <a href="https://developer.cms.gov/marketplace-api/api-spec#/Provider%20%26%20Drug%20Coverage/get_coverage_search" target="_blank">click here</a>',
        summary: 'List of Providers Coverage',
        tags: ['Providers'])
    ]
    #[OA\QueryParameter(
        name: 'query',
        description: 'Search query',
        in: 'query',
        required: false,
        allowEmptyValue: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\QueryParameter(
        name: 'zipcode',
        description: 'Zip code of the providers area',
        in: 'query',
        required: false,
        allowEmptyValue: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Response(
        response: 200,
        description: 'Json with Providers Coverage',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Providers Coverage response',
                        summary: 'Providers Coverage response',
                        value: [
                            'status' => 'success',
                            'data' => [
                                'providers' => [
                                    [
                                        'provider' => [
                                            'npi' => '(title: National Provider Identifier) string with pattern: ^[0-9]{10}$',
                                            'name' => 'string',
                                            'provider_type' => 'string',
                                            'addresses' => 'string',
                                            'plans' => 'string',
                                            'specialties' => [
                                                'string'
                                            ],
                                            'facility_types' => [
                                                'string of (If provider is a facility, this is a list of the applicable facility types)',
                                            ],
                                            'Valid' => 'boolean',
                                            'accepting' => [
                                                'accepting',
                                                'not accepting',
                                                'accepting in some locations',
                                                'unknown'
                                            ],
                                            'gender' => [
                                                'Male',
                                                'Female',
                                                'Other',
                                                'Transgender-female',
                                                'Transgender-male',
                                                'Non-binary',
                                                'Non-disclose'
                                            ],
                                            'languages' => [
                                                'string'
                                            ],
                                            'taxonomy' => '(title: provider taxonomy from National Uniform Claim Committee) string',
                                            'type' => 'string with between the two types: Individual or Facility',
                                            'years' => 'string',
                                            'group_id' => 'string'
                                        ],
                                        'address' => [
                                            'street1' => 'string',
                                            'street2' => 'string',
                                            'city' => 'string',
                                            'state' => 'string',
                                            'zipcode' => 'string',
                                            'phone' => 'string',
                                            'countyfips' => 'string with pattern: 5-digit county FIPS code'
                                        ],
                                        'distance' => '(title: Distance in miles from address, eg., from a proximity search) number with minimum 0'
                                    ]
                                ],
                                'drugs' => [
                                    [
                                        'drug' => [
                                            'id' => '(title: Drug ID) string with pattern: ^[0-9]{1,10}$',
                                            'name' => '(title: Normalized SAB=RXNORM name) string',
                                            'rxcui' => '(title: RxCUI) string with pattern: pattern: ^[0-9]+$',
                                            'strength' => '(title: Strength information for this drug) string',
                                            'route' => '(title: Route information for this drug) string',
                                            'full_name' => '(title: Full name information for this drug) string',
                                            'rxterms_dose_form' => '(title: RxtermsDoseForm value for this drug) string',
                                            'rxnorm_dose_form' => '(title: RxnormDoseForm for this drug) string'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
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
                        example: 'Providers Coverage error response',
                        summary: 'Providers Coverage error response',
                        value: [
                            'status' => 'error',
                            'data' => 'It was not possible to recover the providers coverage.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function coverage(GetProvidersCoverageRequest $request)
    {
        try {
            $providers = ProvidersCoverageActions::providersCoverage($request);
            return response()->json([
                'status' => 'success',
                'data' => $providers,
            ]);
        } catch ( \Exception $e) {
            Log::error('Exception: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover the providers coverage.'
            ], 500);
        }
    }
}
