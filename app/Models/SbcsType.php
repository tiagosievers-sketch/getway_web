<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'SbcsType', allOf: [
    new OA\Schema(
        properties: [
            new OA\Property(property:"deductible", type:"number", format:"float",nullable: true),
            new OA\Property(property:"copay", type:"number", format:"float",nullable: true),
            new OA\Property(property:"coinsurance", type:"number", format:"float",nullable: true),
            new OA\Property(property:"limit", type:"number", format:"float",nullable: true),
        ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractApiModel'),
])]
class SbcsType extends Model
{
    use HasFactory;
}
