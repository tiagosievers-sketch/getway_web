<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Eligibility', allOf: [
    new OA\Schema(
        description: 'Eligibility Model',
        properties: [
            new OA\Property(property:"aptc", type:"number", format:"float"),
            new OA\Property(
                property:"csr",
                description: 'Cost-sharing reduction (CSR)',
                type:"string",
                enum: ["73% AV Level Silver Plan CSR","87% AV Level Silver Plan CSR","94% AV Level Silver Plan CSR"]
            ),
            new OA\Property(property:"hardship_exemption",  type: 'boolean',nullable: false),
            new OA\Property(property:"is_medicaid_chip",  type: 'boolean',nullable: false)
        ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractApiModel'),
])]
class Eligibility extends Model
{
    use HasFactory;
}
