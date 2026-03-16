<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'CurrentEnrollment', allOf: [
    new OA\Schema(properties: [
        new OA\Property(property:"plan_id", type:"string", pattern: '^[0-9]{5}[A-Z]{2}[0-9]{7}$', nullable: false),
        new OA\Property(property:"effective_date", type:"string", pattern: '^[0-9]{4}-[0-9]{2}-[0-9]{2}$'),
        new OA\Property(property:"uses_tobacco", type:"boolean", nullable: true),
    ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractApiModel'),
])]
class CurrentEnrollment extends Model
{
    use HasFactory;
}
