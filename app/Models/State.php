<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'State', allOf: [
    new OA\Schema(properties: [
        new OA\Property(property: 'name', title: 'name', type: 'string', nullable: false),
        new OA\Property(property: 'abbrev', title: 'abbrev', type: 'string', nullable: false),
        new OA\Property(property: 'fips', title: 'fips', type: 'string', nullable: false),
        new OA\Property(property: 'marketplace_model', title: 'marketplace_model', type: 'string', nullable: false),
        new OA\Property(property: 'shop_marketplace_model', title: 'shop_marketplace_model', type: 'string', nullable: false),
        new OA\Property(property: 'hix_name', title: 'hix_name', type: 'string', nullable: false),
        new OA\Property(property: 'hix_url', title: 'hix_url', type: 'string', nullable: false),
        new OA\Property(property: 'shop_hix_name', title: 'shop_hix_name', type: 'string', nullable: false),
        new OA\Property(property: 'shop_hix_url', title: 'shop_hix_url', type: 'string', nullable: false),
        new OA\Property(property: '8962_link', title: '8962_link', type: 'string', nullable: false),
        new OA\Property(property: '8965_link', title: '8965_link', type: 'string', nullable: false),
        new OA\Property(property: 'assister_program_url', title: 'assister_program_url', type: 'string', nullable: false),
    ], type: 'object')
])]
class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abbrev',
        'fips',
        'marketplace_model',
        'shop_marketplace_model',
        'hix_name',
        'hix_url',
        'shop_hix_name',
        'shop_hix_url',
        '8962_link',
        '8965_link',
        'assister_program_url'
    ];

    public function counties(): HasMany
    {
        return $this->hasMany(County::class, 'state', 'abbrev');
    }
}
