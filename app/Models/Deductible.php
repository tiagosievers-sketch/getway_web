<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Deductible', allOf: [
    new OA\Schema(properties: [
        new OA\Property(property:"amount", type:"number", format:"float",nullable: true),
        new OA\Property(property:"csr", type:"string",
            enum: [
                "Exchange variant (no CSR)", "Zero Cost Sharing Plan Variation", "Limited Cost Sharing Plan Variation",
                "73% AV Level Silver Plan CSR","87% AV Level Silver Plan CSR","94% AV Level Silver Plan CSR",
                "Non-Exchange variant", "Unknown CSR"
            ],
            nullable: true),
        new OA\Property(property:"family_cost",description: 'family cost enumeration for MOOPs and deductibles', type:"string",
            enum: [
                "Individual", "Family Per Person", "Family"
            ],
            nullable: true),
        new OA\Property(property:"network_tier", type:"string",
            enum: ["In-Network", "In-Network Tier 2", "Out-of-Network","Combined In-Out of Network"],
            nullable: true),
        new OA\Property(property:"type", type:"string",
            enum: ["Medical EHB Deductible", "Combined Medical and Drug EHB Deductible", "Out-of-Network","Drug EHB Deductible"],
            nullable: true),
        new OA\Property(property:"individual", description: 'Applies to individuals', type: 'boolean',nullable: true),
        new OA\Property(property:"family", description: 'Applies to families', type: 'boolean',nullable: true),
        new OA\Property(property:"display_string", description:"An optional human-readable description", type:"string",nullable: true),
    ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractApiModel'),
])]
class Deductible extends Model
{
    use HasFactory;
}
