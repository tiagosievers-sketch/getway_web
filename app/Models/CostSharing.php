<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'CostSharing', allOf: [
    new OA\Schema(properties: [
        new OA\Property(property:"coinsurance_options", type:"string",nullable: true),
        new OA\Property(property:"coinsurance_rate", type:"number", format:"float",nullable: true),
        new OA\Property(property:"copay_amount", type:"number", format:"float",nullable: true),
        new OA\Property(property:"copay_options", type:"string",nullable: true),
        new OA\Property(property:"network_tier", type:"string", enum: ["In-Network", "In-Network Tier 2", "Out-of-Network",
            "Combined In-Out of Network"],nullable: true),
        new OA\Property(property:"csr", type:"string",
            enum: [
                "Exchange variant (no CSR)", "Zero Cost Sharing Plan Variation", "Limited Cost Sharing Plan Variation",
                "73% AV Level Silver Plan CSR","87% AV Level Silver Plan CSR","94% AV Level Silver Plan CSR",
                "Non-Exchange variant", "Unknown CSR"
            ],
            nullable: true),
        new OA\Property(property:"display_string", type:"string"),
    ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractApiModel'),
])]
class CostSharing extends Model
{
    use HasFactory;
}
