<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'LowestCostPlan', allOf: [
    new OA\Schema(
        description: 'Lowest Cost Plan Model',
        properties: [
            new OA\Property(property:"id", type:"string"),
            new OA\Property(property:"name", type:"string"),
            new OA\Property(property:"premium", type:"number", format:"float"),
            new OA\Property(property:"metal_level", type: 'string', enum: ["Catastrophic", "Silver", "Bronze", "Gold", "Platinum"])
        ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractApiModel'),
])]
class LowestCostPlan extends Model
{
    use HasFactory;
}
