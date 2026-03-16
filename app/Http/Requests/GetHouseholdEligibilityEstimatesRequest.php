<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;
#[OA\Schema(title: 'GetHouseholdEligibilityEstimatesRequest', required: [
    'place'
], properties: [
    new OA\Property(
        property: "household",
        ref: '#/components/schemas/Household',
        nullable: true
    ),
    new OA\Property(
        property: "place",
        ref: '#/components/schemas/Place',
        nullable: false
    ),
    new OA\Property(property:"market", type:"string", enum: [ 'Individual', 'SHOP', 'Any']),
    new OA\Property(property:"year", type:"number", format:"integer",nullable: true),
])]

class GetHouseholdEligibilityEstimatesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'household' => 'array|nullable',
            'place' => 'array|required',
            'place.countyfips' => 'string|max:5|required',
            'place.state' => 'string|max:2|required',
            'place.zipcode' => 'string|max:5|required',
            'year' => 'integer|nullable',
            'market' => "string|nullable"
        ];
    }
}
