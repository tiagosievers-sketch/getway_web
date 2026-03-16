<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'QualityRating', allOf: [
    new OA\Schema(properties: [
        new OA\Property(property:"available",
            description: 'True if the plan has a quality rating, otherwise false. A plan can still be unrated when the quality rating is available',
            type: 'boolean',nullable: true),
        new OA\Property(property:"year", type:"number", format:"integer",nullable: true),
        new OA\Property(property: "global_rating", type: "number", format: "integer", maximum: 5, minimum: 0, nullable: true),
        new OA\Property(property:"global_not_rated_reason", type: 'string',nullable: true),
        new OA\Property(property: "clinical_quality_management_rating", type: "number", format: "integer", maximum: 5, minimum: 0, nullable: true),
        new OA\Property(property:"clinical_quality_management_not_rated_reason", type: 'string',nullable: true),
        new OA\Property(property: "enrollee_experience_rating", type: "number", format: "integer", maximum: 5, minimum: 0, nullable: true),
        new OA\Property(property:"enrollee_experience_not_rated_reason", type: 'string',nullable: true),
        new OA\Property(property: "plan_efficiency_rating", type: "number", format: "integer", maximum: 5, minimum: 0, nullable: true),
        new OA\Property(property:"plan_efficiency_not_rated_reason", type: 'string',nullable: true)
    ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractApiModel'),
])]
class QualityRating extends Model
{
    use HasFactory;
}
