<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'PlanSearchFilter', allOf: [
    new OA\Schema(
        description: 'plan search filter',
        properties: [
            new OA\Property(property:"disease_mgmt_programs", type:"string", enum: ["Asthma", "Heart Disease", "Depression", "Diabetes", "High Blood Pressure and High Cholesterol", "Low Back Pain", "Pain Management" ],nullable: true),
            new OA\Property(property:"division", type:"string", enum: ["HealthCare", "Dental"],nullable: true),
            new OA\Property(property:"issuer", description: 'Issuer name', type: 'string',nullable: true),
            new OA\Property(property:"issuers", description: 'A List of Issuers names', type:"array", items: new OA\Items(type: "string"), nullable: true),
            new OA\Property(property:"metal_levels", description: 'A list of Metallic Levels', type:"array", items: new OA\Items(type: 'string', enum: ["Catastrophic", "Silver", "Bronze", "Gold", "Platinum"]) ,nullable: true),
            new OA\Property(property:"metal_level", type: 'string', enum: ["Catastrophic", "Silver", "Bronze", "Gold", "Platinum"],nullable: true),
            new OA\Property(property:"metal_design_types",description: 'A list of Plan Design Type / Metalic Level Combinations', type:"array",items: new OA\Items(ref:'#/components/schemas/MetalDesignType'),nullable: true),
            new OA\Property(property:"design_types", description: 'A list of Plan Design Types',type:"array", items: new OA\Items(type:"string", enum:["DESIGN1", "DESIGN2", "DESIGN3", "DESIGN4", "DESIGN5", "NOT_APPLICABLE"]),nullable: true),
            new OA\Property(property:"premium", type:"number", format:"float",nullable: true),
            new OA\Property(property:"type", type:"string", enum: ["Indemnity", "PPO", "HMO", "EPO", "POS"],nullable: true),
            new OA\Property(property:"types", description: 'a list of plan types', type:"array", items: new OA\Items(type: 'string',enum: ["Indemnity", "PPO", "HMO", "EPO", "POS"]),nullable: true),
            new OA\Property(property:"deductible", type:"number", format:"float",nullable: true),
            new OA\Property(property:"hsa", description: 'HSA eligibilty',type: 'boolean',nullable: true),
            new OA\Property(property:"oopc", description: 'Out of Pocket Costs',type:"number", format:"float",nullable: true),
            new OA\Property(property:"child_dental_coverage", description: 'Only show plans with child dental coverage',type: 'boolean',nullable: true),
            new OA\Property(property:"adult_dental_coverage", description: 'Only show plans with adult dental coverage',type: 'boolean',nullable: true),
            new OA\Property(property:"drugs", description: 'A list of RXCUIs', type:"array", items: new OA\Items(type: 'string',pattern: '^[0-9]{5,7}$'),nullable: true),
            new OA\Property(property:"providers", description: 'A list of NPIs', type:"array", items: new OA\Items(type: 'string',pattern: '^[0-9]{5,7}$'),nullable: true),
            new OA\Property(property:"quality_rating", description: 'Quality ratings for a plan',type:"number", format:"float",nullable: true),
            new OA\Property(property:"simple_choice",type: 'boolean',nullable: true),
            new OA\Property(property:"premium_range",ref: '#/components/schemas/Range',nullable: true),
            new OA\Property(property:"deductible_range",ref: '#/components/schemas/Range',nullable: true),
        ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractApiModel'),
])]
class PlanSearchFilter extends Model
{
    use HasFactory;
}
