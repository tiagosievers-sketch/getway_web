<?php

namespace App\Http\Controllers;

use App\Actions\StateActions;
use App\Http\Requests\GetStateMedicaidRequest;
use App\Http\Resources\StateMedicaidResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

class StateController extends Controller
{

    /**
     * @throws \Exception
     */
    #[OA\Get(
        path: '/api/v1/geography/states/medicaid',
        description: 'Import or update data from CMS and return Medicaid of State, from <a href="https://developer.cms.gov/marketplace-api/api-spec#/Geography/get_states__abbrev__medicaid" target="_blank">click here</a>',
        summary: 'Import or update data from CMS and return Medicaid of State',
        tags: ['Geography']
    )]
    #[OA\QueryParameter(
        name: 'abbrev',
        description: '2-letter USPS state abbreviation, uppercased.',
        in: 'query',
        required: true,
        allowEmptyValue: false,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\QueryParameter(
        name: 'year',
        description: '4 digit market year (Defaults to the current year when not specified)',
        in: 'query',
        required: false,
        allowEmptyValue: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\QueryParameter(
        name: 'quarter',
        description: 'Numbers 1 to 4. A specific fiscal quarter. When not specified it defaults to the most current data for the specified year.',
        in: 'query',
        required: false,
        allowEmptyValue: false,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Response(response: 200, description: 'data', content: new OA\JsonContent(ref: '#/components/schemas/StateMedicaidResource'))]
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
                        example: 'Error response',
                        summary: 'Error response',
                        value: [
                            'status' => 'error',
                            'data' => 'It was not possible to recover the State Medicaid.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function getStateMedicaid(GetStateMedicaidRequest $request): JsonResponse
    {

        try {
            $medicaid = StateActions::getStateMedicaid($request);
            return response()->json([
                'status' => 'success',
                'data' => $medicaid,
            ]);
        } catch ( \Exception $e) {
            Log::error('Exception: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover the State Medicaid.'
            ], 500);
        }
    }

    #[OA\Get(path: '/api/v1/geography/states/medicaid/db',
        description: 'Return List of Medicaids',
        summary: 'List of Medicaids',
        tags: ['Geography']
    )]
    #[OA\QueryParameter(
        name: 'filter',
        description: '2-letter USPS state abbreviation, uppercased.',
        in: 'query',
        required: true,
        allowEmptyValue: false,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Response(response: 200, description: 'StateMedicaid', content: new OA\JsonContent(ref: '#/components/schemas/StateMedicaidCollection'))]
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
                        example: 'Error response',
                        summary: 'Error response',
                        value: [
                            'status' => 'error',
                            'data' => 'It was not possible to recover the list of Medicaid.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function index(Request $request) {
        return StateActions::listMedicaids($request);
    }

//    #[OA\Get(path: '/api/v1/geography/states/medicaid/db/{medicaid}', description: 'Show a medicaid from an state by id', summary: 'Visualiza um Variável de Indicador', tags: ['Indicadores'])]
//    #[OA\Parameter(name: 'medicaid', description: 'Identificador de um Variável de Indicador Chave Primária', in: 'path')]
//    #[OA\Response(response: 200, description: 'Variável de Indicador', content: new OA\JsonContent(ref: '#/components/schemas/TdIndicadorVariavelResource'))]
//    #[OA\Response(ref: '#/components/responses/401', response: 401)]
//    #[OA\Response(ref: '#/components/responses/403', response: 403)]
//    #[OA\Response(ref: '#/components/responses/404', response: 404)]
//    /**
//     * Display the specified resource.
//     */
//    public function show(TdIndicadorVariavel $tdIndicadorVariavel): TdIndicadorVariavelResource
//    {
//        return StateActions::showMedicaid($tdIndicadorVariavel);
//    }

    /**
     * @throws \Exception
     */
    #[OA\Get(
        path: '/api/v1/geography/states',
        description: 'List all U.S. states. Endpoint: <a href="https://developer.cms.gov/marketplace-api/api-spec#/Geography/get_states" target="_blank">click here</a><br>',
        summary: 'List all U.S. states.',
        tags: ['Geography'])
    ]
    #[OA\Response(
        response: 200,
        description: 'Array of state objects',
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
                                    property:"states",
                                    type:"array",
                                    items: new OA\Items(ref: '#/components/schemas/State')
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
        description: 'Json with States',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'States error response',
                        summary: 'States error response',
                        value: [
                            'status' => 'error',
                            'data' => 'It was not possible to recover any State.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function getAllStates(Request $request): JsonResponse
    {
        try {
            $states = StateActions::listStates($request);
            return response()->json([
                'status' => 'success',
                'data' => ['states'=>$states],
            ]);
        } catch ( \Exception $e) {
            Log::error('Exception: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover any State.'
            ], 500);
        }
    }
}
