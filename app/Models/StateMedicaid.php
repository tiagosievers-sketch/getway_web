<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use OpenApi\Attributes as OA;

#[OA\Schema(title: 'StateMedicaid', allOf: [
    new OA\Schema(properties: [
        new OA\Property(property: 'id', title: 'id', description: 'Primary Key', type: 'integer',
            nullable: false),
        new OA\Property(property: 'name', title: 'name', type: 'string', nullable: false),
        new OA\Property(property: 'abbrev', title: 'abbrev', type: 'string', nullable: false),
        new OA\Property(property: 'fiscal_year', title: 'fiscal_year', type: 'integer', nullable: false),
        new OA\Property(property: 'fiscal_quarter', title: 'fiscal_quarter', type: 'integer', nullable: false),
        new OA\Property(property: 'pc_fpl_parent', title: 'pc_fpl_parent', type: 'number', nullable: false),
        new OA\Property(property: 'pc_fpl_pregnant', title: 'pc_fpl_pregnant', type: 'number', nullable: false),
        new OA\Property(property: 'pc_fpl_adult', title: 'pc_fpl_adult', type: 'number', nullable: false),
        new OA\Property(property: 'pc_fpl_child_newborn', title: 'pc_fpl_child_newborn', type: 'number', nullable: false),
        new OA\Property(property: 'pc_fpl_child_1_5', title: 'pc_fpl_child_1_5', type: 'number', nullable: false),
        new OA\Property(property: 'pc_fpl_child_6_18', title: 'pc_fpl_child_6_18', type: 'number', nullable: false),
        new OA\Property(property: 'lics', title: 'Low Income Child', type: 'array', items: new OA\Items(properties: [],
            allOf: [new OA\Schema(ref: '#/components/schemas/StateMedicaidLic')])),
        new OA\Property(property: 'chips', title: "Children's Health Insurance Program", type: 'array', items: new OA\Items(properties: [],
            allOf: [new OA\Schema(ref: '#/components/schemas/StateMedicaidLic')])),
        new OA\Property(property: 'created_at', title: 'created_at', type: 'string', format: 'string', writeOnly: true, nullable: true),
        new OA\Property(property: 'updated_at', title: 'updated_at', type: 'string', format: 'string', writeOnly: true, nullable: true),
    ], type: 'object')
])]
class StateMedicaid extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abbrev',
        'fiscal_year',
        'fiscal_quarter',
        'pc_fpl_parent',
        'pc_fpl_pregnant',
        'pc_fpl_adult',
        'pc_fpl_child_newborn',
        'pc_fpl_child_1_5',
        'pc_fpl_child_6_18'
    ];

    protected $with = [
        'lics',
        'chips'
    ];

    public function lics(): HasMany
    {
        return $this->hasMany(StateMedicaidLic::class)->where('chip',0);
    }

    public function chips(): HasMany
    {
        return $this->hasMany(StateMedicaidLic::class)->where('chip',1);
    }
}
