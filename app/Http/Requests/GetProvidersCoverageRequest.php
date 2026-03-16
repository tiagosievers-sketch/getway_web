<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;
#[OA\Schema(title: 'GetProvidersCoverageRequest', required: [
    'query',
    'zipcode'
], properties: [
    new OA\Property(property: 'query', title: 'query', type: 'string', nullable: false),
    new OA\Property(property: 'zipcode', title: 'zipcode', type: 'string', nullable: false),
])]
class GetProvidersCoverageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'query'      => 'required|string|max:255',
            'zipcode'     => 'required|string|max:255',
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
