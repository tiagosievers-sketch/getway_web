<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;
#[OA\Schema(title: 'GetStateMedicaidRequest', required: [
    'abbrev',
    'year',
    'quarter'
], properties: [
    new OA\Property(property: 'abbrev', title: 'abbrev', type: 'string', nullable: false),
    new OA\Property(property: 'year', title: 'year', type: 'string', nullable: false),
    new OA\Property(property: 'quarter', title: 'quarter', type: 'string', nullable: false),
])]
class GetStateMedicaidRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'abbrev'      => 'required|string|max:2',
            'year'     => 'nullable|string|max:4',
            'quarter'     => 'nullable|string|max:1',
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
