<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'County', allOf: [
    new OA\Schema(properties: [
        new OA\Property(property: 'fips', title: 'fips', type: 'string'),
        new OA\Property(property: 'name', title: 'name', type: 'string'),
        new OA\Property(property: 'state', title: 'state', type: 'string'),
        new OA\Property(property: 'zipcode', title: 'zipcode', type: 'string'),
    ], type: 'object')
])]
class County extends Model
{
    use HasFactory;

    protected $fillable = [
        'fips',
        'name',
        'state',
        'zipcode'
    ];

    public function stateOfCounty() :BelongsTo
    {
        return $this->belongsTo(State::class, 'state', 'abbrev', 'counties');
    }
}
