<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Range', allOf: [
    new OA\Schema(
        properties: [
            new OA\Property(property:"min", type:"number", format: 'float',nullable: true),
            new OA\Property(property:"max", type:"number", format: 'float',nullable: true),
        ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractApiModel'),
])]
class Range extends Model
{
    use HasFactory;
}
