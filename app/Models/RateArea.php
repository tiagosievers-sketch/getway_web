<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'RateArea', allOf: [
    new OA\Schema(
        description: 'Rate Area',
        properties: [
            new OA\Property(property:"state", description: '2-letter USPS abbreviation', type: 'string'),
            new OA\Property(property:"area", description: 'Rate area number for the given state.', type: 'number', format: 'integer'),
        ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractApiModel'),
])]
class RateArea extends Model
{
    use HasFactory;
}
