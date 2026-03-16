<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'FARSRequest',
    required: ['hubReferenceNumber'],
    properties: [
        new OA\Property(property: "hubReferenceNumber", type: "string", minLength: 1, maxLength: 90),
        new OA\Property(property: "subscriberNumber", type: "string", minLength: 1, maxLength: 7, nullable: true)
    ]
)]
class FARSRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hubReferenceNumber' => 'required|string|min:1|max:90',
            'subscriberNumber' => 'nullable|string|min:1|max:7',
        ];
    }
}
