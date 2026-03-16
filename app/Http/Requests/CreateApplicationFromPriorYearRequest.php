<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;


#[OA\Schema(
    title: 'CreateApplicationFromPriorYearRequest',
    required: ['priorYearApplicationIdentifier'],
    properties: [
        new OA\Property(property: "priorYearApplicationIdentifier", description: "Prior year application id used to create the pre-populated new application.", type: "number"),
        new OA\Property(property: "priorYearVersionNumber", description: "Optional field to specify a version. If not provided, the latest submitted version will be used.", type: "number", nullable: true),
        new OA\Property(property: "coverageYear", description: "The year for which the member(s) on the application is/are applying for coverage.", type: "number"),
        new OA\Property(property: "linkedSystemUserIdentifier", description: "Allows applications to be properly linked to FFM SystemUser documents.", type: "string", nullable: true)
    ]
)]
class CreateApplicationFromPriorYearRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'priorYearApplicationIdentifier' => 'required|integer',
            'priorYearVersionNumber' => 'nullable|integer',
            'coverageYear' => 'nullable|integer',
            'linkedSystemUserIdentifier' => 'nullable|string',
        ];
    }
}
