<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Household', allOf: [
    new OA\Schema(
        description: 'If a household is not included, will default to Individual household',
        properties: [
        new OA\Property(property:"income", type:"number", format:"float", nullable: true),
        new OA\Property(property:"unemployment_received", type:"string", enum: ['Adult', 'Dependent', 'None'], nullable: true),
        new OA\Property(property:"people", type:"array", items: new OA\Items( ref: '#/components/schemas/Person'), nullable: true),
        new OA\Property(property:"has_married_couple", type:"boolean", nullable: true),
        new OA\Property(property:"effective_date", type:"string", pattern: '^[0-9]{4}-[0-9]{2}-[0-9]{2}$', nullable: true)
    ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractModel'),
])]
class Household extends Model
{
    use HasFactory;
}
