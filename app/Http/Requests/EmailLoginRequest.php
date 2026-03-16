<?php

namespace App\Http\Requests;

use App\Rules\Cpf;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;
#[OA\Schema(title: 'EmailRegisterRequest', required: [
    'email',
    'password'
], properties: [
    new OA\Property(property: 'email', ref: '#/components/schemas/User/properties/email'),
    new OA\Property(property: 'password', ref: '#/components/schemas/User/properties/password')
])]

class EmailLoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string',
            'password' => 'required|string',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
