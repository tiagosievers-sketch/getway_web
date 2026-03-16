<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'NetworkAdequacy', allOf: [
    new OA\Schema(
        description: 'Network adequacy',
        properties: [
        new OA\Property(property:"scope", description: 'The county for which the network adequacy is in scope', type: 'string',nullable: true),
        new OA\Property(property: "networks", ref: '#/components/schemas/Network', type: "object", nullable: true),
    ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractApiModel'),
])]
class NetworkAdequacy extends Model
{
    use HasFactory;
}
