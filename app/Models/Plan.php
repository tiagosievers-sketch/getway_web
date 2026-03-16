<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Plan', allOf: [
    new OA\Schema(
        description: 'Plan Model',
        properties: [
            new OA\Property(property:"id", description: '14-character HIOS IDs', type: 'string',nullable: false),
            new OA\Property(property:"name", description: 'Name of the insurance plan', type: 'string',nullable: false),
            new OA\Property(property:"benefits", type:"array",items: new OA\Items(ref:'#/components/schemas/Benefit'),nullable: false),
            new OA\Property(property:"deductibles", type:"array",items: new OA\Items(ref:'#/components/schemas/Deductible'),nullable: false),
            new OA\Property(property:"disease_mgmt_programs", type:"string", enum: ["Asthma", "Heart Disease", "Depression", "Diabetes", "High Blood Pressure and High Cholesterol", "Low Back Pain", "Pain Management" ],nullable: false),
            new OA\Property(property:"has_national_network", description: 'if plan has a national network of providers',type:"boolean", nullable: false),
            new OA\Property(property: "quality_rating", ref: '#/components/schemas/QualityRating', type: "object", nullable: false),
            new OA\Property(property:"insurance_market", type:"string", enum: ["QHP", "MSP"],nullable: false),
            new OA\Property(property:"market", type:"string", enum: [ 'Individual', 'SHOP', 'Any'],nullable: false),
            new OA\Property(property:"max_age_child",description: 'the maximum age a person is considered a child on their parents plan', type:"number", format:"integer",nullable: false),
            new OA\Property(property:"metal_level", type:"string", enum: ["Catastrophic", "Silver", "Bronze", "Gold", "Platinum"],nullable: false),
            new OA\Property(property:"moops", type:"array",items: new OA\Items(ref:'#/components/schemas/Moop'),nullable: false),
            new OA\Property(property:"premium", description: 'monthly premium in US dollars, unsubsidized (i.e., no APTC applied)', type:"number", format:"float",nullable: false),
            new OA\Property(property:"premium_w_credit", description: 'monthly premium in US dollars, with APTC applied', type:"number", format:"float",nullable: false),
            new OA\Property(property:"ehb_premium", description: 'monthly premium in US dollars, for essential health benefits portion of total premium', type:"number", format:"float",nullable: false),
            new OA\Property(property:"pediatric_ehb_premium", description: 'monthly pediatric portion of the ehb premium in US dollars', type:"number", format:"float",nullable: false),
            new OA\Property(property:"aptc_eligible_premium", description: 'the portion of the premium that is eligible for APTC', type:"number", format:"float",nullable: false),
            new OA\Property(property:"guaranteed_rate", description: 'true if the premiums are guaranteed (versus estimated)', type:"boolean",nullable: false),
            new OA\Property(property:"simple_choice", description: 'true if the premiums are guaranteed (versus estimated)', type:"boolean",nullable: false),
            new OA\Property(property:"product_division", type:"string", enum: ["HealthCare", "Dental"],nullable: false),
            new OA\Property(property:"specialist_referral_required",  type: 'boolean',nullable: false),
            new OA\Property(property:"state", description: '2-letter USPS state abbreviation', type: 'string',nullable: false),
            new OA\Property(property:"type", type:"string", enum: ["Indemnity", "PPO", "HMO", "EPO", "POS"],nullable: false),
            new OA\Property(property:"benefits_url", type: 'string',nullable: false),
            new OA\Property(property:"brochure_url", type: 'string',nullable: false),
            new OA\Property(property:"formulary_url", type: 'string',nullable: false),
            new OA\Property(property:"network_url", type: 'string',nullable: false),
            new OA\Property(property:"hsa_eligible", description: 'Is this plan eligible as an HSA?',type: 'boolean',nullable: false),
            new OA\Property(property:"oopc", description: 'out-of-pocket cost; calculated when age, gender and utilization_level are present, otherwise -1', type:"number", format:"float",nullable: false),
            new OA\Property(property:"suppression_state", type:"string", enum: ["Available", "Suspended", "Closed", "Not Applicable"],nullable: false),
            new OA\Property(property:"tobacco_lookback", type:"number", format:"integer",nullable: false),
            new OA\Property(property:"certification", type:"string", enum: ["Certified", "Not Certified", "Decertified", "Certified Off-Exchange SADP"],nullable: false),
            new OA\Property(property: "network_adequacy", ref: '#/components/schemas/NetworkAdequacy', type: "object", nullable: false),
            new OA\Property(property: "sbcs", ref: '#/components/schemas/Sbcs', type: "object", nullable: false),
            new OA\Property(property:"rx_3mo_mail_order", description: '3-month in-network mail order pharmacy benefit',type: 'boolean',nullable: false),
            new OA\Property(property:"is_ineligible", description: 'If the given enrollment group/household is ineligible for the plan by business rules, it will be flagged true',type: 'boolean',nullable: false),
            new OA\Property(property:"covers_nonhyde_abortion", type: 'boolean',nullable: false),
            new OA\Property(property:"service_area_id", description: "6-character id representing the geographic area the plan accepts members from. The first two characters are the state's abbreviation.", type: 'string',nullable: false),
        ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractApiModel'),
])]
class Plan extends AbstractModel
{
    use HasFactory;
    public $incrementing = false;
}
