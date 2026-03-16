<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'MetalDesignType', allOf: [
    new OA\Schema(
        description: 'Metal Design Type',
        properties: [
            new OA\Property(property:"metal_level", type:"string", enum: ["Catastrophic", "Silver", "Bronze", "Gold", "Platinum"],nullable: true),
            new OA\Property(property:"design_types", description: 'A list of Plan Design Types',type:"array", items: new OA\Items(type:"string", enum:["DESIGN1", "DESIGN2", "DESIGN3", "DESIGN4", "DESIGN5", "NOT_APPLICABLE"]),nullable: true),
        ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractApiModel'),
])]
class MetalDesignType extends Model
{
    use HasFactory;
}
