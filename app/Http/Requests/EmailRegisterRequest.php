<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;
#[OA\Schema(title: 'EmailRegisterRequest', required: [
    'name',
    'email',
    'password'
], properties: [
    new OA\Property(property: 'name', ref: '#/components/schemas/User/properties/name'),
    new OA\Property(property: 'email', ref: '#/components/schemas/User/properties/email'),
    new OA\Property(property: 'password', ref: '#/components/schemas/User/properties/password')
])]
class EmailRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|max:255|unique:users',
            'password'  => 'required|string'
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
