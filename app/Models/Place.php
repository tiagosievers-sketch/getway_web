<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Place', allOf: [
    new OA\Schema(properties: [
        new OA\Property(property: "countyfips", description: '5-digit county FIPS code', type: "string", nullable: false),
        new OA\Property(property: "state", description: '2-letter USPS state abbreviation', type: "string", nullable: false),
        new OA\Property(property: "zipcode", description: '5-digit ZIP Code', type: "string", nullable: false),
    ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractApiModel'),
])]
class Place extends Model
{
    use HasFactory;
}
