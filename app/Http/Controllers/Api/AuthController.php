<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailLoginRequest;
use App\Http\Requests\EmailRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(path: '/api/v1/auth/register-email', description: 'Register with e-mail', summary: 'Register with e-mail', tags: ['Users'])]
    #[OA\RequestBody(
        description: 'Requisition body for register with e-mail',
        required: true,
        content: [
            new OA\MediaType(
                mediaType: "application/json" ,
                schema: new OA\Schema('#/components/schemas/EmailRegisterRequest')
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: 'Success to register',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Success to register',
                        summary: 'Success to register',
                        value: [
                            'status' => 'success',
                            'data' => 'User data',
                            'access_token'  => 'Token code',
                            'token_type'    => 'Bearer'
                        ],
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function register(EmailRegisterRequest $request)
    {
        $user = User::create([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'password'  => Hash::make($request->input('password'))
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'data'          => $user,
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    #[OA\Post(path: '/api/v1/auth/login-email', description: 'Login with e-mail', summary: 'Login with e-mail', tags: ['Users'])]
    #[OA\RequestBody(
        description: 'Requisition body for login with e-mail',
        required: true,
        content: [
            new OA\MediaType(
                mediaType: "application/json" ,
                schema: new OA\Schema('#/components/schemas/EmailLoginRequest')
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: 'Success to register',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Success to login',
                        summary: 'Success to login',
                        value: [
                            'message' => 'Login success',
                            'access_token'  => 'Token code',
                            'token_type'    => 'Bearer'
                        ],
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    #[OA\Response(ref: '#/components/responses/401', response: 401)]
    public function login(EmailLoginRequest $request)
    {
        $credentials    =   $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }

        $user   = User::where('email', $request->input('email'))->firstOrFail();
        $token  = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'       => 'Login success',
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);

    }

    #[OA\Post(path: '/api/v1/auth/logout', description: 'Logout', summary: 'Logout', tags: ['Users'])]
    #[OA\Response(
        response: 200,
        description: 'Success to logout',
        content: [
            new OA\JsonContent(
                examples: [
                    new OA\Examples(
                        example: 'Success to logout',
                        summary: 'Success to logout',
                        value: [
                            'message' => 'Logout successfull'
                        ],
                    ),
                ],
                discriminator: new OA\Discriminator('response',)
            ),
        ]
    )]
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout successfull'
        ]);
    }
}
