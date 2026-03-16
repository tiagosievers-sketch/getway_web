<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Sbcs', allOf: [
    new OA\Schema(
        description: 'Summary of benefits and costs',
        properties: [
            new OA\Property(property: "baby", ref: '#/components/schemas/SbcsType',
                description: 'Typical yearly costs for having a healthy pregnancy and normal delivery for one person', type: "object", nullable: false),
            new OA\Property(property: "diabetes", ref: '#/components/schemas/SbcsType',
                description: 'Typical yearly costs for managing type 2 diabetes for one person', type: "object", nullable: false),
            new OA\Property(property: "fracture", ref: '#/components/schemas/SbcsType',
                description: 'Typical yearly costs for treating a simple fracture', type: "object", nullable: false),
        ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractApiModel'),
])]
class Sbcs extends Model
{
    use HasFactory;
}
