<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Benefit', allOf: [
    new OA\Schema(properties: [
        new OA\Property(property:"name", type:"string",nullable: true),
        new OA\Property(property:"covered", type:"boolean",nullable: true),
        new OA\Property(property:"cost_sharings", type:"array",items: new OA\Items(ref:'#/components/schemas/CostSharing'), nullable: true),
        new OA\Property(property:"explanation", type:"string",nullable: true),
        new OA\Property(property:"has_limits", type:"boolean",nullable: true),
        new OA\Property(property:"limit_unit", type:"string",nullable: true),
        new OA\Property(property:"limit_quantity", type:"number", format:"float",nullable: true),
    ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractApiModel'),
])]
class Benefit extends Model
{
    use HasFactory;
}
