<?php

namespace App\Http\Controllers\Hub;

use App\Actions\Hub\ApplicationActions;
use App\Actions\InsurancePlansActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddMembersRequest;
use App\Http\Requests\CreateApplicationFromPriorYearRequest;
use App\Http\Requests\CreateApplicationRequest;
use App\Http\Requests\GetPlansRequest;
use App\Http\Requests\GetPlansSearchRequest;
use App\Http\Requests\GetPlanWithPremiumsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use phpseclib3\Math\PrimeField\Integer;

use OpenApi\Attributes as OA;

class ApplicationController extends Controller {
    /**
    * @throws \Exception
    */
    #[OA\Post(
        path: '/api/v1/applications',
        description: 'Create a new application using the provided details.',
        summary: 'Create Application',
        tags: ['Applications']
    )]
    #[OA\RequestBody(
        description: 'Send a body with the application details.',
        required: true,
        content: [
            new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema('#/components/schemas/CreateApplicationRequest')
            )
        ]
    )]
    #[OA\Response(
        response: 201,
        description: 'Application created successfully',
        content: new OA\JsonContent(ref: '#/components/schemas/Application')
    )]
    #[OA\Response(ref: '#/components/responses/401', response: 401)]
    #[OA\Response(ref: '#/components/responses/403', response: 403)]
    #[OA\Response(ref: '#/components/responses/404', response: 404)]
    #[OA\Response(
        response: 500,
        description: 'Error creating application',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Application creation error response',
                        summary: 'Application creation error response',
                        value: [
                            'status' => 'error',
                            'message' => 'It was not possible to create the application.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function createApplication(CreateApplicationRequest $request): JsonResponse
    {
        try {
            $application = ApplicationActions::create($request);
            return response()->json([
                'status' => 'success',
                'data' => $application,
            ], 201);
        } catch ( \Exception $e) {
            Log::error('Exception: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to create the application.'
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    #[OA\Post(
        path: '/api/v1/applications/prior-year',
        description: 'Create a new application using data from the prior year.',
        summary: 'Create Application - Prior Year',
        tags: ['Applications']
    )]
    #[OA\RequestBody(
        description: 'Send a body with the prior year application details.',
        required: true,
        content: [
            new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema('#/components/schemas/CreateApplicationFromPriorYearRequest')
            )
        ]
    )]
    #[OA\Response(
        response: 201,
        description: 'Application created successfully from prior year data',
        content: new OA\JsonContent(ref: '#/components/schemas/Application')
    )]
    #[OA\Response(ref: '#/components/responses/401', response: 401)]
    #[OA\Response(ref: '#/components/responses/403', response: 403)]
    #[OA\Response(ref: '#/components/responses/404', response: 404)]
    #[OA\Response(
        response: 500,
        description: 'Error creating application from prior year',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Application creation prior year error response',
                        summary: 'Application creation prior year error response',
                        value: [
                            'status' => 'error',
                            'message' => 'It was not possible to create the application from prior year.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function createApplicationFromPriorYear(CreateApplicationFromPriorYearRequest $request): JsonResponse
    {
        try {
            $application = ApplicationActions::createFromPriorYear($request);
            return response()->json([
                'status' => 'success',
                'data' => $application,
            ], 201);
        } catch ( \Exception $e) {
            Log::error('Exception: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to create the application from prior year.'
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    #[OA\Get(
        path: '/api/v1/applications/{applicationId}',
        description: 'Retrieve the details of a specific application.',
        summary: 'Get Application',
        tags: ['Applications']
    )]
    #[OA\Parameter(
        name: 'applicationId',
        description: 'The unique identifier of the application to retrieve.',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Response(
        response: 200,
        description: 'Application retrieved successfully',
        content: new OA\JsonContent(ref: '#/components/schemas/Application')
    )]
    #[OA\Response(ref: '#/components/responses/401', response: 401)]
    #[OA\Response(ref: '#/components/responses/403', response: 403)]
    #[OA\Response(ref: '#/components/responses/404', response: 404)]
    #[OA\Response(
        response: 500,
        description: 'Error retrieving application',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Application retrieval error response',
                        summary: 'Application retrieval error response',
                        value: [
                            'status' => 'error',
                            'message' => 'It was not possible to retrieve the application.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function getApplication(string $applicationId): JsonResponse
    {
        try {
            $application = ApplicationActions::get($applicationId);
            return response()->json([
                'status' => 'success',
                'data' => $application,
            ]);
        } catch ( \Exception $e) {
            Log::error('Exception: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to retrieve the application.'
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    #[OA\Post(
        path: '/api/v1/applications/{applicationId}/members',
        description: 'Add a new member to an existing application.',
        summary: 'Add Member',
        tags: ['Applications']
    )]
    #[OA\Parameter(
        name: 'applicationId',
        description: 'The unique identifier of the application to add a member to.',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\RequestBody(
        description: 'Send a body with the member details.',
        required: true,
        content: [
            new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema('#/components/schemas/AddMembersRequest')
            )
        ]
    )]
    #[OA\Response(
        response: 201,
        description: 'Member added successfully',
        content: new OA\JsonContent(ref: '#/components/schemas/Application')
    )]
    #[OA\Response(ref: '#/components/responses/401', response: 401)]
    #[OA\Response(ref: '#/components/responses/403', response: 403)]
    #[OA\Response(ref: '#/components/responses/404', response: 404)]
    #[OA\Response(
        response: 500,
        description: 'Error adding member to application',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Member addition error response',
                        summary: 'Member addition error response',
                        value: [
                            'status' => 'error',
                            'message' => 'It was not possible to add the member to the application.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function addMember(string $applicationId, AddMembersRequest $request): JsonResponse
    {
        try {
            $application = ApplicationActions::addMember($applicationId, $request);
            return response()->json([
                'status' => 'success',
                'data' => $application,
            ], 201);
        } catch ( \Exception $e) {
            Log::error('Exception: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to add the member to the application.'
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    #[OA\Put(
        path: '/api/v1/applications/{applicationId}',
        description: 'Update an existing application with new information.',
        summary: 'Update Application',
        tags: ['Applications']
    )]
    #[OA\Parameter(
        name: 'applicationId',
        description: 'The unique identifier of the application to update.',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\RequestBody(
        description: 'Send a body with the updated application details.',
        required: true,
        content: [
            new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema('#/components/schemas/UpdateApplicationRequest')
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: 'Application updated successfully',
        content: new OA\JsonContent(ref: '#/components/schemas/Application')
    )]
    #[OA\Response(ref: '#/components/responses/401', response: 401)]
    #[OA\Response(ref: '#/components/responses/403', response: 403)]
    #[OA\Response(ref: '#/components/responses/404', response: 404)]
    #[OA\Response(
        response: 500,
        description: 'Error updating application',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Application update error response',
                        summary: 'Application update error response',
                        value: [
                            'status' => 'error',
                            'message' => 'It was not possible to update the application.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function updateApplication(string $applicationId, UpdateApplicationRequest $request): JsonResponse
    {
        try {
            $application = ApplicationActions::update($applicationId, $request);
            return response()->json([
                'status' => 'success',
                'data' => $application,
            ]);
        } catch ( \Exception $e) {
            Log::error('Exception: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to update the application.'
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    #[OA\Post(
        path: '/api/v1/applications/{applicationId}/submissions',
        description: 'Submit an application for final processing.',
        summary: 'Submit Application',
        tags: ['Applications']
    )]
    #[OA\Parameter(
        name: 'applicationId',
        description: 'The unique identifier of the application to submit.',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Response(
        response: 200,
        description: 'Application submitted successfully',
        content: new OA\JsonContent(ref: '#/components/schemas/Application')
    )]
    #[OA\Response(ref: '#/components/responses/401', response: 401)]
    #[OA\Response(ref: '#/components/responses/403', response: 403)]
    #[OA\Response(ref: '#/components/responses/404', response: 404)]
    #[OA\Response(
        response: 500,
        description: 'Error submitting application',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Application submission error response',
                        summary: 'Application submission error response',
                        value: [
                            'status' => 'error',
                            'message' => 'It was not possible to submit the application.'
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function submitApplication(string $applicationId): JsonResponse
    {
        try {
            $submission = ApplicationActions::submit($applicationId);
            return response()->json([
                'status' => 'success',
                'data' => $submission,
            ]);
        } catch ( \Exception $e) {
            Log::error('Exception: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to submit the application.'
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    #[OA\Delete(
        path: '/api/v1/applications/{applicationId}',
        description: 'Delete an existing application.',
        summary: 'Delete Application',
        tags: ['Applications']
    )]
    #[OA\Parameter(
        name: 'applicationId',
        description: 'The unique identifier of the application to delete.',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Response(
        response: 200,
        description: 'Application deleted successfully',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Application deleted successfully response',
                        summary: 'Application deleted successfully response',
                        value: [
                            'status' => 'success',
                            'message' => 'Application deleted successfully.',
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
        description: 'Error deleting application',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Application deletion error response',
                        summary: 'Application deletion error response',
                        value: [
                            'status' => 'success',
                            'message' => 'It was not possible to delete the application.',
                            'data' => true
                        ]
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function deleteApplication(string $applicationId): JsonResponse
    {
        try {
            $result = ApplicationActions::delete($applicationId);
            return response()->json([
                'status' => 'success',
                'message' => 'Application deleted successfully.',
                'data' => $result
            ]);
        } catch ( \Exception $e) {
            Log::error('Exception: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to delete the application.'
            ], 500);
        }
    }

}
