<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use OpenApi\Attributes as OA;

#[OA\Schema(title: 'StateMedicaidLic', allOf: [
    new OA\Schema(properties: [
        new OA\Property(property: 'id', title: 'id', description: 'Primary Key', type: 'integer',
            nullable: false),
        new OA\Property(property: 'chip', title: 'chip', type: 'boolean', nullable: false),
        new OA\Property(property: 'min_age', title: 'min_age', type: 'integer', nullable: false),
        new OA\Property(property: 'max_age', title: 'max_age', type: 'integer', nullable: false),
        new OA\Property(property: 'pc_fpl', title: 'pc_fpl', type: 'number', nullable: false),
        new OA\Property(property: 'state_medicaid_id', title: 'state_medicaid_id', type: 'integer', nullable: false),
        new OA\Property(property: 'created_at', title: 'created_at', type: 'string', format: 'string', writeOnly: true, nullable: true),
        new OA\Property(property: 'updated_at', title: 'updated_at', type: 'string', format: 'string', writeOnly: true, nullable: true),
    ], type: 'object')
])]

class StateMedicaidLic extends Model
{
    use HasFactory;

    protected $fillable = [
        'chip',
        'min_age',
        'max_age',
        'pc_fpl',
        'state_medicaid_id'
    ];

    public function medicaid(): BelongsTo
    {
        return $this->belongsTo(StateMedicaid::class);
    }
}
