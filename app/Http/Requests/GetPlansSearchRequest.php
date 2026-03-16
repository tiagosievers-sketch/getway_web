<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;
#[OA\Schema(title: 'GetPlansSearchRequest', required: [
    'place',
    'market'
], properties: [
    new OA\Property(
        property: "filter",
        ref: '#/components/schemas/PlanSearchFilter',
        nullable: true
    ),
    new OA\Property(
        property: "household",
        ref: '#/components/schemas/Household',
        nullable: true
    ),
    new OA\Property(property:"limit", type:"number", format:"integer",nullable: true),
    new OA\Property(property:"offset", type:"number", format:"integer",nullable: true),
    new OA\Property(property:"order", type:"string", enum: [ 'asc', 'desc'],nullable: true),
    new OA\Property(
        property: "place",
        ref: '#/components/schemas/Place',
        nullable: false
    ),
    new OA\Property(property:"sort", type:"string", enum: [ 'premium', 'deductible', 'oopc', 'total_costs', 'quality_rating '],nullable: true),
    new OA\Property(property:"year", description: 'defaults to current open enrollment year',type:"number", format:"integer",nullable: true),
    new OA\Property(property:"market", type:"string", enum: [ 'Individual', 'SHOP', 'Any'],nullable: false),
    new OA\Property(property:"aptc_override", description: 'override the aptc calculation with a specific amount',type:"number", format:"float",nullable: true),
    new OA\Property(property:"csr_override", description: 'Cost-sharing reduction (CSR) override for requests', type:"string", enum: [ 'CSR73', 'CSR87', 'CSR94', 'LimitedCSR', 'ZeroCSR' ],nullable: true),
    new OA\Property(property:"catastrophic_override", description: 'Force the display (or suppression) of catastrophic plans',type:"boolean",nullable: true),
    new OA\Property(property:"suppressed_plan_ids", type:"array", items: new OA\Items(
        type: 'string', pattern: '^[0-9]{5}[A-Z]{2}[0-9]{7}(,[0-9]{5}[A-Z]{2}[0-9]{7})*$'
    ),nullable: false),
])]

class GetPlansSearchRequest extends FormRequest
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
            'filter' => 'array|nullable',
            'household' => 'array|nullable',
            'limit' => 'integer|nullable',
            'offset' => 'integer|nullable',
            'order' => 'string|nullable',
            'sort' => "string|nullable",
            'year' => 'integer|nullable',
            'place' => 'array|required',
            'place.countyfips' => 'string|max:5|required',
            'place.state' => 'string|max:2|required',
            'place.zipcode' => 'string|max:5|required',
            'market' => "string|required",
            'aptc_override' => 'numeric|nullable',
            'csr_override' => "string|nullable",
            'catastrophic_override' => 'boolean|nullable',
            'suppressed_plan_ids' => 'array|nullable',
        ];
    }
}
