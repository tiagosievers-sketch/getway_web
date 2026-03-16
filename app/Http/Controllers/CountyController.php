<?php

namespace App\Http\Controllers;

use App\Actions\CountyActions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use OpenApi\Attributes as OA;

class CountyController extends Controller
{


    /**
     * @throws \Exception
     */
    #[OA\Get(
        path: '/api/v1/geography/counties/zipcode/{zipcode}',
        description: 'Find counties matching ZIP Code (5 digits or prefix thereof). This method is suitable for use in typeahead UI completions. Endpoint: <a href="https://developer.cms.gov/marketplace-api/api-spec#/Geography/get_counties_by_zip__zipcode_" target="_blank">click here</a><br>',
        summary: 'Find counties matching ZIP Code (5 digits or prefix thereof)',
        tags: ['Geography'])
    ]
    #[OA\Parameter(
        name: 'zipcode',
        description: '5 digit ZIP Code or 1-4 digit prefix of a ZIP Code',
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
        description: 'Array of counties objects',
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
                                    property:"counties",
                                    type:"array",
                                    items: new OA\Items(ref: '#/components/schemas/County')
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
        description: 'Json with Counties by zipcode',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Counties by zipcode error response',
                        summary: 'Counties by zipcode error response',
                        value: [
                            'status' => 'error',
                            'data' => 'It was not possible to recover counties by zipcode.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function countiesByZip(Request $request, $zipcode): JsonResponse
    {
        try {
            $counties = CountyActions::getCountiesByZipcode($zipcode,$request);
            return response()->json([
                'status' => 'success',
                'data' => $counties,
            ]);
        } catch ( \Exception $e) {
            Log::error('Exception: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover counties by zipcode.'
            ], 500);
        }
    }
}
