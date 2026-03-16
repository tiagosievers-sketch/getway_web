<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'RIDPRequest',
    required: ['personGivenName', 'personSurName', 'streetName', 'cityName', 'usStateCode', 'zipCode'],
    properties: [
        new OA\Property(property: "personGivenName", type: "string", minLength: 1, maxLength: 32),
        new OA\Property(property: "personSurName", type: "string", minLength: 1, maxLength: 32),
        new OA\Property(property: "personMiddleName", type: "string", minLength: 1, maxLength: 32, nullable: true),
        new OA\Property(property: "personSuffixName", type: "string", maxLength: 3, nullable: true),
        new OA\Property(property: "personBirthDate", type: "string", format: "date", example: "YYYY-MM-DD", nullable: true),
        new OA\Property(property: "personSocialSecurityNumber", type: "string", pattern: "123-45-6789|6789|123456789", nullable: true),
        new OA\Property(property: "streetName", type: "string", minLength: 1, maxLength: 60),
        new OA\Property(property: "cityName", type: "string", minLength: 1, maxLength: 40),
        new OA\Property(property: "usStateCode", type: "string", enum: ["AL", "AK", "AZ", "AR", "CA", "CO", "CT", "DE", "FL", "GA", "HI", "ID", "IL", "IN", "IA", "KS", "KY", "LA", "ME", "MD", "MA", "MI", "MN", "MS", "MO", "MT", "NE", "NV", "NH", "NJ", "NM", "NY", "NC", "ND", "OH", "OK", "OR", "PA", "RI", "SC", "SD", "TN", "TX", "UT", "VT", "VA", "WA", "WV", "WI", "WY"]),
        new OA\Property(property: "zipCode", type: "string", minLength: 5, maxLength: 5),
        new OA\Property(property: "zipCodeExtension", type: "string", minLength: 4, maxLength: 4, nullable: true),
        new OA\Property(property: "telephoneNumber", type: "string", pattern: "(\d{3})?\d{3}-\d{4}", nullable: true),
        new OA\Property(property: "levelOfProofingCode", type: "string", enum: ["LevelTwo", "LevelThree", "OptionThree"], nullable: true),
        new OA\Property(property: "personPreferredLanguage", type: "string", enum: ["eng", "spa"], nullable: true),
        new OA\Property(property: "subscriberNumber", type: "string", nullable: true)
    ]
)]
class RIDPRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'personGivenName' => 'required|string|min:1|max:32',
            'personSurName' => 'required|string|min:1|max:32',
            'personMiddleName' => 'nullable|string|min:1|max:32',
            'personSuffixName' => 'nullable|string|max:3',
            'personBirthDate' => 'nullable|string|date_format:Y-m-d',
            'personSocialSecurityNumber' => 'nullable|string|regex:/\d{3}-\d{2}-\d{4}|\d{4}|\d{9}/',
            'streetName' => 'required|string|min:1|max:60',
            'cityName' => 'required|string|min:1|max:40',
            'usStateCode' => 'required|string|size:2',
            'zipCode' => 'required|string|size:5',
            'zipCodeExtension' => 'nullable|string|size:4',
            'telephoneNumber' => 'nullable|string|regex:/(\d{3})?\d{3}-\d{4}/',
            'levelOfProofingCode' => 'nullable|string|in:LevelTwo,LevelThree,OptionThree',
            'personPreferredLanguage' => 'nullable|string|in:eng,spa',
            'subscriberNumber' => 'nullable|string|min:1|max:7',
        ];
    }
}
